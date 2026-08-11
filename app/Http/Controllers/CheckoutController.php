<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Services\Payments\ChipClient;
use App\Services\Payments\ChipPaymentSynchronizer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Throwable;

class CheckoutController extends Controller
{
    public function index(Request $request): Response
    {
        $defaultPackage = in_array($request->query('package'), array_keys(config('packages')), true)
            ? $request->query('package')
            : 'basic';

        return Inertia::render('Checkout/Index', [
            'packages' => array_values(config('packages')),
            'defaultPackage' => $defaultPackage,
        ]);
    }

    public function store(Request $request, ChipClient $chip): SymfonyResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:128'],
            'email' => ['required', 'email:rfc', 'max:254'],
            'package' => ['required', Rule::in(array_keys(config('packages')))],
        ]);

        /** @var array{code: string, name: string, price_sen: int, child_limit: int|null, reseller: bool} $package */
        $package = config('packages.'.$validated['package']);

        $affiliateId = (int) $request->session()->get('affiliate_user_id');
        $affiliateId = (int) User::query()
            ->whereKey($affiliateId)
            ->where('affiliate_active', true)
            ->whereIn('role', ['affiliate', 'admin'])
            ->value('id');

        $uuid = (string) Str::uuid();
        $payment = Payment::create([
            'uuid' => $uuid,
            'customer_name' => $validated['name'],
            'customer_email' => Str::lower($validated['email']),
            'package_code' => $package['code'],
            'affiliate_user_id' => $affiliateId ?: null,
            'provider' => 'chip',
            'reference' => 'JOMKID-'.Str::upper(Str::substr($uuid, 0, 8)),
            'status' => Payment::STATUS_INITIALIZED,
            'amount_sen' => $package['price_sen'],
            'currency' => 'MYR',
        ]);

        try {
            $purchase = $chip->createPurchase($payment);
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

            return back()->withErrors([
                'payment' => 'Pembayaran CHIP tidak dapat dimulakan. Sila cuba lagi sebentar lagi.',
            ]);
        }
    }

    public function success(
        Payment $payment,
        ChipClient $chip,
        ChipPaymentSynchronizer $synchronizer,
    ): Response {
        $payment = $this->refreshFromChip($payment, $chip, $synchronizer);

        return $this->result($payment);
    }

    public function failure(
        Payment $payment,
        ChipClient $chip,
        ChipPaymentSynchronizer $synchronizer,
    ): Response {
        $payment = $this->refreshFromChip($payment, $chip, $synchronizer);

        return $this->result($payment);
    }

    private function result(Payment $payment): Response
    {
        return Inertia::render('Checkout/Result', [
            'payment' => [
                ...$payment->only(['uuid', 'status', 'amount_sen', 'currency', 'paid_at']),
                'email_hint' => $this->maskEmail($payment->customer_email),
            ],
            'successful' => $payment->status === Payment::STATUS_PAID,
        ]);
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

    private function maskEmail(string $email): string
    {
        [$local, $domain] = array_pad(explode('@', $email, 2), 2, '');

        return Str::substr($local, 0, 2).'***@'.$domain;
    }
}
