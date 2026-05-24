<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'pastoral_counseling_case_id',
    'type',
    'provider_name',
    'contact',
    'status',
    'referred_at',
    'notes',
])]
class PastoralSupportReferral extends Model
{
    public function case(): BelongsTo
    {
        return $this->belongsTo(PastoralCounselingCase::class, 'pastoral_counseling_case_id');
    }

    public function scopeVisibleTo(Builder $query, ?User $user): Builder
    {
        return $query->whereHas('case', fn (Builder $query) => $query->visibleTo($user));
    }

    protected function casts(): array
    {
        return [
            'referred_at' => 'datetime',
            'notes' => 'encrypted',
        ];
    }
}
