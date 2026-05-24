<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable([
    'child_profile_id',
    'child_age_group_id',
    'checked_in_by_guardian_id',
    'checked_out_by_guardian_id',
    'pickup_authorization_id',
    'check_in_code',
    'pickup_code',
    'checked_in_at',
    'checked_out_at',
    'label_printed_at',
    'status',
    'notes',
])]
class ChildCheckIn extends Model
{
    protected static function booted(): void
    {
        static::creating(function (ChildCheckIn $checkIn): void {
            $checkIn->check_in_code ??= strtoupper(Str::random(8));
            $checkIn->pickup_code ??= (string) random_int(100000, 999999);
            $checkIn->checked_in_at ??= now();
            $checkIn->status ??= 'checked_in';
        });
    }

    public function child(): BelongsTo
    {
        return $this->belongsTo(ChildProfile::class, 'child_profile_id');
    }

    public function ageGroup(): BelongsTo
    {
        return $this->belongsTo(ChildAgeGroup::class, 'child_age_group_id');
    }

    public function checkedInBy(): BelongsTo
    {
        return $this->belongsTo(ChildGuardian::class, 'checked_in_by_guardian_id');
    }

    public function checkedOutBy(): BelongsTo
    {
        return $this->belongsTo(ChildGuardian::class, 'checked_out_by_guardian_id');
    }

    public function pickupAuthorization(): BelongsTo
    {
        return $this->belongsTo(ChildPickupAuthorization::class);
    }

    public function emergencyCalls(): HasMany
    {
        return $this->hasMany(ChildEmergencyCall::class);
    }

    protected function casts(): array
    {
        return [
            'checked_in_at' => 'datetime',
            'checked_out_at' => 'datetime',
            'label_printed_at' => 'datetime',
        ];
    }
}
