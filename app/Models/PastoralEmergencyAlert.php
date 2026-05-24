<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'pastoral_counseling_case_id',
    'triggered_by_user_id',
    'status',
    'contact_phone',
    'message',
    'triggered_at',
    'resolved_at',
])]
class PastoralEmergencyAlert extends Model
{
    public function case(): BelongsTo
    {
        return $this->belongsTo(PastoralCounselingCase::class, 'pastoral_counseling_case_id');
    }

    public function triggeredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'triggered_by_user_id');
    }

    public function scopeVisibleTo(Builder $query, ?User $user): Builder
    {
        return $query->where(function (Builder $query) use ($user): void {
            $query->whereNull('pastoral_counseling_case_id')
                ->orWhereHas('case', fn (Builder $query) => $query->visibleTo($user));
        });
    }

    protected function casts(): array
    {
        return [
            'message' => 'encrypted',
            'triggered_at' => 'datetime',
            'resolved_at' => 'datetime',
        ];
    }
}
