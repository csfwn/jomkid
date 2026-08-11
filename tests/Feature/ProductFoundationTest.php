<?php

namespace Tests\Feature;

use App\Models\AffiliateCommission;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductFoundationTest extends TestCase
{
    use RefreshDatabase;

    public function test_pricing_and_commission_are_stored_in_integer_sen(): void
    {
        $affiliate = User::factory()->create(['role' => User::ROLE_AFFILIATE]);
        $buyer = User::factory()->create();
        $subscription = Subscription::create([
            'user_id' => $buyer->id,
            'status' => 'active',
            'price_sen' => 6900,
        ]);

        $commission = AffiliateCommission::create([
            'affiliate_user_id' => $affiliate->id,
            'buyer_user_id' => $buyer->id,
            'subscription_id' => $subscription->id,
            'amount_sen' => 3450,
        ]);

        $this->assertSame(6900, $subscription->price_sen);
        $this->assertSame(3450, $commission->amount_sen);
        $this->assertSame('pending', $commission->refresh()->status);
    }
}
