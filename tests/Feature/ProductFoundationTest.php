<?php

namespace Tests\Feature;

use App\Models\AffiliateCommission;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProductFoundationTest extends TestCase
{
    use RefreshDatabase;

    public function test_lifetime_price_and_commission_are_stored_in_integer_sen(): void
    {
        $affiliate = User::factory()->create(['role' => User::ROLE_AFFILIATE]);
        $payment = Payment::create([
            'uuid' => (string) Str::uuid(),
            'customer_name' => 'Buyer',
            'customer_email' => 'buyer@example.com',
            'affiliate_user_id' => $affiliate->id,
            'provider' => 'chip',
            'provider_purchase_id' => (string) Str::uuid(),
            'reference' => 'JOMKID-'.Str::upper(Str::random(8)),
            'status' => Payment::STATUS_PAID,
            'amount_sen' => 6900,
            'currency' => 'MYR',
        ]);

        $commission = AffiliateCommission::create([
            'affiliate_user_id' => $affiliate->id,
            'payment_id' => $payment->id,
            'amount_sen' => 3450,
        ]);

        $this->assertSame(6900, $payment->amount_sen);
        $this->assertSame(3450, $commission->amount_sen);
        $this->assertSame('pending', $commission->refresh()->status);
    }
}
