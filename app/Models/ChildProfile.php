<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'child_age_group_id',
    'full_name',
    'birth_date',
    'gender',
    'allergies',
    'medical_conditions',
    'photo',
    'status',
    'notes',
])]
class ChildProfile extends Model
{
    public function ageGroup(): BelongsTo
    {
        return $this->belongsTo(ChildAgeGroup::class, 'child_age_group_id');
    }

    public function guardians(): HasMany
    {
        return $this->hasMany(ChildGuardian::class);
    }

    public function checkIns(): HasMany
    {
        return $this->hasMany(ChildCheckIn::class);
    }

    public function pickupAuthorizations(): HasMany
    {
        return $this->hasMany(ChildPickupAuthorization::class);
    }

    public function emergencyCalls(): HasMany
    {
        return $this->hasMany(ChildEmergencyCall::class);
    }

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }
}
