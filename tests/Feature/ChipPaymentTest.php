<?php

namespace Tests\Feature;

use App\Models\AccessCode;
use App\Models\AffiliateCommission;
use App\Models\Payment;
use App\Models\User;
use App\Notifications\LifetimeAccessCodeIssued;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
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

    public function test_visitor_can_create_a_lifetime_chip_purchase_before_registration(): void
    {
        $purchaseId = (string) Str::uuid();
        Http::fake([
            'https://gate.chip-in.asia/api/v1/purchases/' => Http::response([
                'id' => $purchaseId,
                'status' => 'created',
                'checkout_url' => "https://gate.chip-in.asia/p/{$purchaseId}/",
            ], 201),
        ]);

        $this->post('/checkout', [
            'name' => 'Test Parent',
            'email' => 'parent@example.com',
        ])->assertRedirect("https://gate.chip-in.asia/p/{$purchaseId}/");

        $payment = Payment::query()->sole();
        $this->assertNull($payment->user_id);
        $this->assertNull($payment->subscription_id);
        $this->assertSame('parent@example.com', $payment->customer_email);
        $this->assertSame(6900, $payment->amount_sen);
        $this->assertSame($purchaseId, $payment->provider_purchase_id);

        Http::assertSent(function ($request) use ($payment): bool {
            return $request->url() === 'https://gate.chip-in.asia/api/v1/purchases/'
                && $request->hasHeader('Authorization', 'Bearer test-secret')
                && $request['client']['email'] === 'parent@example.com'
                && $request['purchase']['products'][0]['name'] === 'JomKid Lifetime Access'
                && $request['purchase']['products'][0]['price'] === 6900
                && $request['reference'] === $payment->reference;
        });
    }

    public function test_affiliate_referral_is_attached_to_public_checkout(): void
    {
        $affiliate = User::factory()->create([
            'role' => 'affiliate',
            'affiliate_active' => true,
            'affiliate_code' => 'SELLER3',
        ]);
        $purchaseId = (string) Str::uuid();
        Http::fake([
            'https://gate.chip-in.asia/api/v1/purchases/' => Http::response([
                'id' => $purchaseId,
                'status' => 'created',
                'checkout_url' => "https://gate.chip-in.asia/p/{$purchaseId}/",
            ], 201),
        ]);

        $this->get('/?ref=seller3')->assertSessionHas('affiliate_user_id', $affiliate->id);
        $this->post('/checkout', [
            'name' => 'Buyer',
            'email' => 'buyer@example.com',
        ])->assertRedirect();

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
        $this->assertDatabaseCount('access_codes', 0);
    }

    public function test_paid_webhook_emails_exactly_one_single_use_code_idempotently(): void
    {
        Notification::fake();
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

        $this->assertSame(Payment::STATUS_PAID, $payment->refresh()->status);
        $this->assertSame($firstPaidAt, $payment->paid_at?->toISOString());
        $this->assertDatabaseCount('access_codes', 1);
        $this->assertDatabaseCount('affiliate_commissions', 1);
        $accessCode = AccessCode::query()->sole();
        $this->assertSame(64, strlen($accessCode->code_hash));
        $this->assertSame(AccessCode::STATUS_ACTIVE, $accessCode->status);
        $commission = AffiliateCommission::query()->sole();
        $this->assertSame(3450, $commission->amount_sen);
        $this->assertSame($payment->id, $commission->payment_id);
        Notification::assertSentOnDemandTimes(LifetimeAccessCodeIssued::class, 1);
    }

    public function test_refund_revokes_used_access_and_affiliate_commission(): void
    {
        Notification::fake();
        $affiliate = User::factory()->create([
            'role' => 'affiliate',
            'affiliate_active' => true,
            'affiliate_code' => 'SELLER2',
        ]);
        $payment = $this->createPayment($affiliate);
        $paidBody = json_encode($this->paidPayload($payment), JSON_THROW_ON_ERROR);
        $this->postRawWebhook($paidBody, $this->sign($paidBody))->assertOk();

        $user = User::factory()->create(['access_status' => 'active']);
        $accessCode = AccessCode::query()->sole();
        $accessCode->update([
            'status' => AccessCode::STATUS_USED,
            'used_by_user_id' => $user->id,
            'used_at' => now(),
        ]);

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
        $this->assertSame(AccessCode::STATUS_REVOKED, $accessCode->refresh()->status);
        $this->assertSame('revoked', $user->refresh()->access_status);
        $this->assertSame('reversed', AffiliateCommission::query()->sole()->status);

        $this->postRawWebhook($paidBody, $this->sign($paidBody))->assertOk();
        $this->assertSame(Payment::STATUS_REFUNDED, $payment->refresh()->status);
        $this->assertDatabaseCount('access_codes', 1);
    }

    public function test_success_redirect_verifies_status_server_side_and_issues_code(): void
    {
        Notification::fake();
        $payment = $this->createPayment();
        Http::fake([
            "https://gate.chip-in.asia/api/v1/purchases/{$payment->provider_purchase_id}/" => Http::response(
                $this->paidPayload($payment),
            ),
        ]);

        $this->get(route('checkout.success', $payment))->assertOk();

        $this->assertSame(Payment::STATUS_PAID, $payment->refresh()->status);
        $this->assertDatabaseCount('access_codes', 1);
        Notification::assertSentOnDemand(LifetimeAccessCodeIssued::class);
    }

    private function createPayment(?User $affiliate = null): Payment
    {
        return Payment::create([
            'uuid' => (string) Str::uuid(),
            'customer_name' => 'Test Parent',
            'customer_email' => 'buyer@example.com',
            'affiliate_user_id' => $affiliate?->id,
            'provider' => 'chip',
            'provider_purchase_id' => (string) Str::uuid(),
            'reference' => 'JOMKID-'.Str::upper(Str::random(8)),
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
                    'name' => 'JomKid Lifetime Access',
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
