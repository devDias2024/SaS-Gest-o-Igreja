<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'pastoral_counseling_case_id',
    'pastor_user_id',
    'scheduled_at',
    'duration_minutes',
    'location_type',
    'location',
    'meeting_url',
    'status',
    'reminder_at',
    'reminder_sent_at',
    'confidential_notes',
    'next_steps',
])]
class PastoralCounselingSession extends Model
{
    public function case(): BelongsTo
    {
        return $this->belongsTo(PastoralCounselingCase::class, 'pastoral_counseling_case_id');
    }

    public function pastor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pastor_user_id');
    }

    public function scopeVisibleTo(Builder $query, ?User $user): Builder
    {
        return $query->whereHas('case', fn (Builder $query) => $query->visibleTo($user));
    }

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'reminder_at' => 'datetime',
            'reminder_sent_at' => 'datetime',
            'confidential_notes' => 'encrypted',
            'next_steps' => 'encrypted',
        ];
    }
}
