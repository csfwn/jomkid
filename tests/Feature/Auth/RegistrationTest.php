<?php

namespace Tests\Feature\Auth;

use App\Models\AccessCode;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Fortify\Features;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->skipUnlessFortifyHas(Features::registration());
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $this->get(route('register'))->assertOk();
    }

    public function test_registration_is_blocked_without_an_access_code(): void
    {
        $this->post(route('register.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertSessionHasErrors('access_code');

        $this->assertGuest();
        $this->assertDatabaseCount('users', 0);
    }

    public function test_paid_single_use_code_registers_one_lifetime_user(): void
    {
        $plainCode = 'JOMKID-ABCD-EFGH-JKLM';
        $accessCode = $this->createAccessCode($plainCode, 'test@example.com');

        $response = $this->post(route('register.store'), [
            'access_code' => $plainCode,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
        $user = User::query()->sole();
        $this->assertSame('active', $user?->access_status);
        $this->assertSame('basic', $user->package_code);
        $this->assertSame(3, $user->child_profile_limit);
        $this->assertFalse($user->affiliate_active);
        $this->assertNull($user->affiliate_code);
        $this->assertNotNull($user?->lifetime_access_at);
        $this->assertSame(AccessCode::STATUS_USED, $accessCode->refresh()->status);
        $this->assertSame($user?->id, $accessCode->used_by_user_id);
        $this->assertSame($user?->id, $accessCode->payment?->user_id);
    }

    public function test_used_code_cannot_register_another_user(): void
    {
        $plainCode = 'JOMKID-WXYZ-1234-5678';
        $accessCode = $this->createAccessCode($plainCode, 'second@example.com');
        $accessCode->update(['status' => AccessCode::STATUS_USED, 'used_at' => now()]);

        $this->post(route('register.store'), [
            'access_code' => $plainCode,
            'name' => 'Second User',
            'email' => 'second@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertSessionHasErrors('access_code');

        $this->assertGuest();
        $this->assertDatabaseCount('users', 0);
    }

    public function test_premium_code_grants_reseller_and_unlimited_children(): void
    {
        $plainCode = 'JOMKID-PREM-IUM0-0001';
        $this->createAccessCode($plainCode, 'premium@example.com', 'premium');

        $this->post(route('register.store'), [
            'access_code' => $plainCode,
            'name' => 'Premium User',
            'email' => 'premium@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('dashboard', absolute: false));

        $user = User::query()->sole();
        $this->assertSame('premium', $user->package_code);
        $this->assertNull($user->child_profile_limit);
        $this->assertSame(User::ROLE_AFFILIATE, $user->role);
        $this->assertTrue($user->affiliate_active);
        $this->assertNotNull($user->affiliate_code);
    }

    public function test_code_is_bound_to_purchase_email(): void
    {
        $plainCode = 'JOMKID-MAIL-ONLY-0001';
        $this->createAccessCode($plainCode, 'buyer@example.com');

        $this->post(route('register.store'), [
            'access_code' => $plainCode,
            'name' => 'Wrong Email',
            'email' => 'other@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    private function createAccessCode(string $plainCode, string $email, string $package = 'basic'): AccessCode
    {
        /** @var array{price_sen: int} $packageConfig */
        $packageConfig = config('packages.'.$package);

        $payment = Payment::create([
            'uuid' => (string) Str::uuid(),
            'customer_name' => 'Test Parent',
            'customer_email' => $email,
            'package_code' => $package,
            'provider' => 'chip',
            'provider_purchase_id' => (string) Str::uuid(),
            'reference' => 'JOMKID-'.Str::upper(Str::random(8)),
            'status' => Payment::STATUS_PAID,
            'amount_sen' => $packageConfig['price_sen'],
            'currency' => 'MYR',
            'paid_at' => now(),
        ]);

        return AccessCode::create([
            'payment_id' => $payment->id,
            'email' => $email,
            'code_hash' => AccessCode::hashCode($plainCode),
            'code_hint' => Str::substr($plainCode, -4),
            'status' => AccessCode::STATUS_ACTIVE,
        ]);
    }
}
