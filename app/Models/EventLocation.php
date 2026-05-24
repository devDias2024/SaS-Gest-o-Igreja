<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'address',
    'capacity',
    'latitude',
    'longitude',
    'geofence_radius_meters',
    'is_active',
    'notes',
])]
class EventLocation extends Model
{
    public function events(): HasMany
    {
        return $this->hasMany(ChurchEvent::class);
    }

    protected function casts(): array
    {
        return [
            'capacity' => 'integer',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'geofence_radius_meters' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
