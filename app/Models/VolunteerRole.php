<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'color', 'default_slots', 'rotates_automatically', 'is_active', 'description'])]
class VolunteerRole extends Model
{
    public function assignments(): HasMany
    {
        return $this->hasMany(EventVolunteerAssignment::class);
    }

    protected function casts(): array
    {
        return [
            'default_slots' => 'integer',
            'rotates_automatically' => 'boolean',
            'is_active' => 'boolean',
        ];
    }
}
