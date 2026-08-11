<?php

namespace Tests\Feature;

use App\Models\AffiliateCommission;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ChipPaymentTest extends TestCase
{
    use RefreshDatabase;

    private string $privateKey = '';

    private string $publicKey = '';

    protected function setUp(): void
    {
        parent::setUp();

        $key = openssl_pkey_new([
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
        ]);
        openssl_pkey_export($key, $this->privateKey);
        $details = openssl_pkey_get_details($key);
        $this->publicKey = $details['key'];

        config([
            'services.chip.base_url' => 'https://gate.chip-in.asia/api/v1',
            'services.chip.secret_key' => 'test-secret',
            'services.chip.brand_id' => '409eb80e-3782-4b1d-afa8-b779759266a5',
            'services.chip.public_key' => $this->publicKey,
        ]);
    }

    public function test_parent_can_create_a_chip_checkout_purchase(): void
    {
        $user = User::factory()->create();
        $purchaseId = (string) Str::uuid();

        Http::fake([
            'https://gate.chip-in.asia/api/v1/purchases/' => Http::response([
                'id' => $purchaseId,
                'status' => 'created',
                'checkout_url' => "https://gate.chip-in.asia/p/{$purchaseId}/",
            ], 201),
        ]);

        $response = $this->actingAs($user)->post('/checkout');

        $response->assertRedirect("https://gate.chip-in.asia/p/{$purchaseId}/");
        $payment = Payment::query()->sole();
        $this->assertSame(6900, $payment->amount_sen);
        $this->assertSame($purchaseId, $payment->provider_purchase_id);
        $this->assertSame(Payment::STATUS_CREATED, $payment->status);
        $this->assertSame('pending', $payment->subscription?->status);

        Http::assertSent(function ($request) use ($payment, $user): bool {
            return $request->url() === 'https://gate.chip-in.asia/api/v1/purchases/'
                && $request->hasHeader('Authorization', 'Bearer test-secret')
                && $request['brand_id'] === '409eb80e-3782-4b1d-afa8-b779759266a5'
                && $request['client']['email'] === $user->email
                && $request['purchase']['products'][0]['price'] === 6900
                && $request['reference'] === $payment->reference
                && $request['success_callback'] === route('webhooks.chip');
        });
    }

    public function test_active_subscription_cannot_start_an_overlapping_checkout(): void
    {
        $user = User::factory()->create();
        Subscription::create([
            'user_id' => $user->id,
            'plan_code' => 'jomkid-annual',
            'status' => 'active',
            'price_sen' => 6900,
            'starts_at' => now(),
            'ends_at' => now()->addMonths(6),
        ]);
        Http::fake();

        $this->actingAs($user)
            ->from('/checkout')
            ->post('/checkout')
            ->assertRedirect('/checkout')
            ->assertSessionHasErrors('payment');

        $this->assertDatabaseCount('payments', 0);
        Http::assertNothingSent();
    }

    public function test_affiliate_referral_is_attached_to_checkout(): void
    {
        $affiliate = User::factory()->create([
            'role' => 'affiliate',
            'affiliate_active' => true,
            'affiliate_code' => 'SELLER3',
        ]);
        $buyer = User::factory()->create();
        $purchaseId = (string) Str::uuid();
        Http::fake([
            'https://gate.chip-in.asia/api/v1/purchases/' => Http::response([
                'id' => $purchaseId,
                'status' => 'created',
                'checkout_url' => "https://gate.chip-in.asia/p/{$purchaseId}/",
            ], 201),
        ]);

        $this->get('/?ref=seller3')->assertSessionHas('affiliate_user_id', $affiliate->id);
        $this->actingAs($buyer)->post('/checkout')->assertRedirect();

        $this->assertSame($affiliate->id, Payment::query()->sole()->affiliate_user_id);
    }

    public function test_webhook_rejects_an_invalid_signature(): void
    {
        $payment = $this->createPayment();
        $rawBody = json_encode($this->paidPayload($payment), JSON_THROW_ON_ERROR);

        $this->call('POST', '/webhooks/chip', [], [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_X_SIGNATURE' => base64_encode('not-a-valid-signature'),
        ], $rawBody)->assertUnauthorized();

        $this->assertSame(Payment::STATUS_CREATED, $payment->refresh()->status);
        $this->assertSame('pending', $payment->subscription?->refresh()->status);
    }

    public function test_cancelled_webhook_closes_pending_subscription(): void
    {
        $payment = $this->createPayment();
        $payload = $this->paidPayload($payment);
        $payload['status'] = 'cancelled';
        $payload['event_type'] = 'purchase.cancelled';
        $rawBody = json_encode($payload, JSON_THROW_ON_ERROR);

        $this->postRawWebhook($rawBody, $this->sign($rawBody))->assertOk();

        $this->assertSame(Payment::STATUS_CANCELLED, $payment->refresh()->status);
        $this->assertSame('cancelled', $payment->subscription?->refresh()->status);
    }

    public function test_verified_paid_webhook_activates_subscription_idempotently(): void
    {
        $affiliate = User::factory()->create([
            'role' => 'affiliate',
            'affiliate_active' => true,
            'affiliate_code' => 'SELLER1',
        ]);
        $payment = $this->createPayment($affiliate);
        $rawBody = json_encode($this->paidPayload($payment), JSON_THROW_ON_ERROR);
        $signature = $this->sign($rawBody);

        $this->postRawWebhook($rawBody, $signature)->assertOk();
        $firstPaidAt = $payment->refresh()->paid_at?->toISOString();

        $this->postRawWebhook($rawBody, $signature)->assertOk();

        $payment->refresh();
        $subscription = $payment->subscription?->refresh();
        $this->assertSame(Payment::STATUS_PAID, $payment->status);
        $this->assertSame($firstPaidAt, $payment->paid_at?->toISOString());
        $this->assertSame('active', $subscription?->status);
        $this->assertNotNull($subscription?->starts_at);
        $this->assertNotNull($subscription?->ends_at);
        $this->assertDatabaseCount('affiliate_commissions', 1);
        $commission = AffiliateCommission::query()->sole();
        $this->assertSame(3450, $commission->amount_sen);
        $this->assertSame('pending', $commission->status);
        $this->assertSame($affiliate->id, $commission->affiliate_user_id);
    }

    public function test_refund_reverses_access_and_affiliate_commission(): void
    {
        $affiliate = User::factory()->create([
            'role' => 'affiliate',
            'affiliate_active' => true,
            'affiliate_code' => 'SELLER2',
        ]);
        $payment = $this->createPayment($affiliate);
        $paidBody = json_encode($this->paidPayload($payment), JSON_THROW_ON_ERROR);
        $this->postRawWebhook($paidBody, $this->sign($paidBody))->assertOk();

        $refundPayload = [
            'id' => (string) Str::uuid(),
            'event_type' => 'payment.refunded',
            'related_to' => [
                'type' => 'purchase',
                'id' => $payment->provider_purchase_id,
            ],
            'reference' => $payment->reference,
            'payment' => [
                'payment_type' => 'refund',
                'amount' => 6900,
                'currency' => 'MYR',
            ],
        ];
        $refundBody = json_encode($refundPayload, JSON_THROW_ON_ERROR);
        $this->postRawWebhook($refundBody, $this->sign($refundBody))->assertOk();

        $this->assertSame(Payment::STATUS_REFUNDED, $payment->refresh()->status);
        $this->assertSame('cancelled', $payment->subscription?->refresh()->status);
        $this->assertSame('reversed', AffiliateCommission::query()->sole()->status);

        $this->postRawWebhook($paidBody, $this->sign($paidBody))->assertOk();
        $this->assertSame(Payment::STATUS_REFUNDED, $payment->refresh()->status);
    }

    public function test_success_redirect_verifies_status_with_chip_server_side(): void
    {
        $payment = $this->createPayment();
        Http::fake([
            "https://gate.chip-in.asia/api/v1/purchases/{$payment->provider_purchase_id}/" => Http::response(
                $this->paidPayload($payment),
            ),
        ]);

        $this->actingAs($payment->user)
            ->get(route('checkout.success', $payment))
            ->assertOk();

        $this->assertSame(Payment::STATUS_PAID, $payment->refresh()->status);
        $this->assertSame('active', $payment->subscription?->refresh()->status);
    }

    private function createPayment(?User $affiliate = null): Payment
    {
        $user = User::factory()->create();
        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan_code' => 'jomkid-annual',
            'status' => 'pending',
            'price_sen' => 6900,
        ]);

        return Payment::create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $user->id,
            'affiliate_user_id' => $affiliate?->id,
            'subscription_id' => $subscription->id,
            'provider' => 'chip',
            'provider_purchase_id' => (string) Str::uuid(),
            'reference' => 'JOMKID-'.$user->id.'-'.Str::upper(Str::random(8)),
            'status' => Payment::STATUS_CREATED,
            'amount_sen' => 6900,
            'currency' => 'MYR',
        ]);
    }

    /** @return array<string, mixed> */
    private function paidPayload(Payment $payment): array
    {
        return [
            'id' => $payment->provider_purchase_id,
            'status' => 'paid',
            'event_type' => 'purchase.paid',
            'reference' => $payment->reference,
            'purchase' => [
                'total' => 6900,
                'currency' => 'MYR',
                'products' => [[
                    'name' => 'JomKid Annual Access',
                    'price' => 6900,
                ]],
            ],
        ];
    }

    private function sign(string $rawBody): string
    {
        openssl_sign($rawBody, $signature, $this->privateKey, OPENSSL_ALGO_SHA256);

        return base64_encode($signature);
    }

    private function postRawWebhook(string $rawBody, string $signature): TestResponse
    {
        return $this->call('POST', '/webhooks/chip', [], [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_X_SIGNATURE' => $signature,
        ], $rawBody);
    }
}
