<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'affiliate_user_id', 'buyer_user_id', 'payment_id',
    'amount_sen', 'status', 'available_at', 'paid_at',
])]
class AffiliateCommission extends Model
{
    protected function casts(): array
    {
        return ['available_at' => 'datetime', 'paid_at' => 'datetime'];
    }

    /** @return BelongsTo<User, $this> */
    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'affiliate_user_id');
    }

    /** @return BelongsTo<User, $this> */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_user_id');
    }

    /** @return BelongsTo<Payment, $this> */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }
}
