<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'min_age_months',
    'max_age_months',
    'location',
    'capacity',
    'is_active',
    'notes',
])]
class ChildAgeGroup extends Model
{
    public function children(): HasMany
    {
        return $this->hasMany(ChildProfile::class);
    }

    public function checkIns(): HasMany
    {
        return $this->hasMany(ChildCheckIn::class);
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
