<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['learning_module_id', 'slug', 'title', 'description', 'difficulty', 'duration_minutes', 'xp_reward', 'is_published', 'sort_order'])]
class Lesson extends Model
{
    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }

    /** @return BelongsTo<LearningModule, $this> */
    public function module(): BelongsTo
    {
        return $this->belongsTo(LearningModule::class, 'learning_module_id');
    }

    /** @return HasMany<LessonAttempt, $this> */
    public function attempts(): HasMany
    {
        return $this->hasMany(LessonAttempt::class);
    }
}
