<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'church_event_id',
    'member_id',
    'event_registration_id',
    'guest_name',
    'method',
    'checked_in_at',
    'latitude',
    'longitude',
    'inside_geofence',
    'device_id',
    'qr_token',
    'synced_from_offline',
    'notes',
])]
class EventCheckIn extends Model
{
    public function event(): BelongsTo
    {
        return $this->belongsTo(ChurchEvent::class, 'church_event_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(EventRegistration::class, 'event_registration_id');
    }

    protected function casts(): array
    {
        return [
            'checked_in_at' => 'datetime',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'inside_geofence' => 'boolean',
            'synced_from_offline' => 'boolean',
        ];
    }
}
