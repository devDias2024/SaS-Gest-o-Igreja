<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'child_profile_id',
    'member_id',
    'name',
    'relationship',
    'phone',
    'email',
    'document_number',
    'photo',
    'is_primary',
    'can_pickup',
    'notes',
])]
class ChildGuardian extends Model
{
    public function child(): BelongsTo
    {
        return $this->belongsTo(ChildProfile::class, 'child_profile_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function checkInsDroppedOff(): HasMany
    {
        return $this->hasMany(ChildCheckIn::class, 'checked_in_by_guardian_id');
    }

    public function checkInsPickedUp(): HasMany
    {
        return $this->hasMany(ChildCheckIn::class, 'checked_out_by_guardian_id');
    }

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'can_pickup' => 'boolean',
        ];
    }
}
