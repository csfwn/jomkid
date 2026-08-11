<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'payment_id', 'used_by_user_id', 'email', 'code_hash', 'code_hint',
    'status', 'used_at',
])]
class AccessCode extends Model
{
    public const STATUS_ACTIVE = 'active';

    public const STATUS_USED = 'used';

    public const STATUS_REVOKED = 'revoked';

    protected function casts(): array
    {
        return ['used_at' => 'datetime'];
    }

    /** @return BelongsTo<Payment, $this> */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    /** @return BelongsTo<User, $this> */
    public function usedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'used_by_user_id');
    }

    public static function hashCode(string $code): string
    {
        return hash('sha256', self::normalize($code));
    }

    public static function normalize(string $code): string
    {
        return strtoupper(trim($code));
    }
}
