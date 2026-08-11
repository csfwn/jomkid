<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['child_profile_id', 'lesson_id', 'score', 'max_score', 'accuracy', 'status', 'meta', 'completed_at'])]
class LessonAttempt extends Model
{
    protected function casts(): array
    {
        return ['meta' => 'array', 'completed_at' => 'datetime', 'accuracy' => 'decimal:2'];
    }

    /** @return BelongsTo<ChildProfile, $this> */
    public function childProfile(): BelongsTo
    {
        return $this->belongsTo(ChildProfile::class);
    }

    /** @return BelongsTo<Lesson, $this> */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
