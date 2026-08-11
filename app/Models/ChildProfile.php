<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'display_name', 'birth_year', 'avatar_key', 'leaderboard_opt_in'])]
class ChildProfile extends Model
{
    protected function casts(): array
    {
        return ['leaderboard_opt_in' => 'boolean'];
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return HasMany<LessonAttempt, $this> */
    public function attempts(): HasMany
    {
        return $this->hasMany(LessonAttempt::class);
    }
}
