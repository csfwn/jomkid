<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'uuid', 'customer_name', 'customer_email', 'package_code', 'user_id', 'affiliate_user_id',
    'provider', 'provider_purchase_id',
    'reference', 'status', 'amount_sen', 'currency', 'checkout_url',
    'provider_payload', 'paid_at', 'failed_at',
])]
class Payment extends Model
{
    public const STATUS_INITIALIZED = 'initialized';

    public const STATUS_CREATED = 'created';

    public const STATUS_PAID = 'paid';

    public const STATUS_FAILED = 'failed';

    public const STATUS_CANCELLED = 'cancelled';

    protected function casts(): array
    {
        return [
            'provider_payload' => 'array',
            'paid_at' => 'datetime',
            'failed_at' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsTo<User, $this> */
    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'affiliate_user_id');
    }

    /** @return HasOne<AccessCode, $this> */
    public function accessCode(): HasOne
    {
        return $this->hasOne(AccessCode::class);
    }
}
