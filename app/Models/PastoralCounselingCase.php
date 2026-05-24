<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'member_id',
    'primary_pastor_user_id',
    'title',
    'status',
    'main_subject',
    'privacy_level',
    'opened_at',
    'closed_at',
    'lgpd_consented_at',
    'lgpd_consent_text',
    'emergency_contact_name',
    'emergency_contact_phone',
    'risk_notes',
])]
class PastoralCounselingCase extends Model
{
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function primaryPastor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'primary_pastor_user_id');
    }

    public function authorizedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'pastoral_counseling_case_user')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(PastoralCounselingSession::class);
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(PastoralSupportReferral::class);
    }

    public function emergencyAlerts(): HasMany
    {
        return $this->hasMany(PastoralEmergencyAlert::class);
    }

    public function scopeVisibleTo(Builder $query, ?User $user): Builder
    {
        if (! $user) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where(function (Builder $query) use ($user): void {
            $query->where('primary_pastor_user_id', $user->id)
                ->orWhereHas('authorizedUsers', fn (Builder $query) => $query->whereKey($user->id));
        });
    }

    protected function casts(): array
    {
        return [
            'opened_at' => 'datetime',
            'closed_at' => 'datetime',
            'lgpd_consented_at' => 'datetime',
            'lgpd_consent_text' => 'encrypted',
            'risk_notes' => 'encrypted',
        ];
    }
}
