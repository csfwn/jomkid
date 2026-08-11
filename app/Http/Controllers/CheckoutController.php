<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Services\Payments\ChipClient;
use App\Services\Payments\ChipPaymentSynchronizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Throwable;

class CheckoutController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Checkout/Index', [
            'plan' => [
                'name' => 'JomKid Annual Access',
                'price_sen' => 6900,
                'currency' => 'MYR',
                'child_limit' => 3,
            ],
            'activeSubscription' => $request->user()->subscriptions()
                ->where('status', 'active')
                ->latest()
                ->first(),
        ]);
    }

    public function store(Request $request, ChipClient $chip): SymfonyResponse
    {
        $hasActiveAccess = $request->user()->subscriptions()
            ->where('status', 'active')
            ->where(function ($query): void {
                $query->whereNull('ends_at')->orWhere('ends_at', '>', now());
            })
            ->exists();

        if ($hasActiveAccess) {
            return back()->withErrors([
                'payment' => 'Langganan JomKid anda masih aktif.',
            ]);
        }

        [$subscription, $payment] = DB::transaction(function () use ($request): array {
            $subscription = $request->user()->subscriptions()->create([
                'plan_code' => 'jomkid-annual',
                'status' => 'pending',
                'price_sen' => 6900,
            ]);

            $uuid = (string) Str::uuid();
            $affiliateId = (int) $request->session()->get('affiliate_user_id');
            if ($affiliateId === $request->user()->id) {
                $affiliateId = 0;
            }
            $affiliateId = (int) User::query()
                ->whereKey($affiliateId)
                ->where('affiliate_active', true)
                ->whereIn('role', ['affiliate', 'admin'])
                ->value('id');

            $payment = $request->user()->payments()->create([
                'uuid' => $uuid,
                'affiliate_user_id' => $affiliateId ?: null,
                'subscription_id' => $subscription->id,
                'provider' => 'chip',
                'reference' => 'JOMKID-'.$request->user()->id.'-'.Str::upper(Str::substr($uuid, 0, 8)),
                'status' => Payment::STATUS_INITIALIZED,
                'amount_sen' => 6900,
                'currency' => 'MYR',
            ]);

            return [$subscription, $payment];
        });

        try {
            $purchase = $chip->createPurchase($request->user(), $payment);
            $purchaseId = data_get($purchase, 'id');
            $checkoutUrl = data_get($purchase, 'checkout_url');

            if (! is_string($purchaseId) || ! Str::isUuid($purchaseId) || ! is_string($checkoutUrl) || $checkoutUrl === '') {
                throw new RuntimeException('CHIP returned an incomplete purchase response.');
            }

            $payment->update([
                'provider_purchase_id' => $purchaseId,
                'checkout_url' => $checkoutUrl,
                'status' => Payment::STATUS_CREATED,
                'provider_payload' => $purchase,
            ]);

            return Inertia::location($checkoutUrl);
        } catch (Throwable $exception) {
            report($exception);
            $payment->update(['status' => Payment::STATUS_FAILED, 'failed_at' => now()]);
            $subscription->update(['status' => 'failed']);

            return back()->withErrors([
                'payment' => 'Pembayaran CHIP tidak dapat dimulakan. Sila cuba lagi sebentar lagi.',
            ]);
        }
    }

    public function success(
        Request $request,
        Payment $payment,
        ChipClient $chip,
        ChipPaymentSynchronizer $synchronizer,
    ): Response|RedirectResponse {
        $this->authorizePayment($request, $payment);
        $payment = $this->refreshFromChip($payment, $chip, $synchronizer);

        return Inertia::render('Checkout/Result', [
            'payment' => $payment->only(['uuid', 'status', 'amount_sen', 'currency', 'paid_at']),
            'successful' => $payment->status === Payment::STATUS_PAID,
        ]);
    }

    public function failure(
        Request $request,
        Payment $payment,
        ChipClient $chip,
        ChipPaymentSynchronizer $synchronizer,
    ): Response {
        $this->authorizePayment($request, $payment);
        $payment = $this->refreshFromChip($payment, $chip, $synchronizer);

        return Inertia::render('Checkout/Result', [
            'payment' => $payment->only(['uuid', 'status', 'amount_sen', 'currency', 'paid_at']),
            'successful' => $payment->status === Payment::STATUS_PAID,
        ]);
    }

    private function authorizePayment(Request $request, Payment $payment): void
    {
        abort_unless($payment->user_id === $request->user()->id, 403);
    }

    private function refreshFromChip(
        Payment $payment,
        ChipClient $chip,
        ChipPaymentSynchronizer $synchronizer,
    ): Payment {
        if (! $payment->provider_purchase_id) {
            return $payment;
        }

        try {
            return $synchronizer->sync($payment, $chip->retrievePurchase($payment->provider_purchase_id));
        } catch (Throwable $exception) {
            report($exception);

            return $payment->refresh();
        }
    }
}
