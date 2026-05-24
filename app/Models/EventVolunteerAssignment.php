<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'church_event_id',
    'volunteer_role_id',
    'member_id',
    'slot_number',
    'status',
    'auto_assigned',
    'notified_at',
    'notes',
])]
class EventVolunteerAssignment extends Model
{
    public function event(): BelongsTo
    {
        return $this->belongsTo(ChurchEvent::class, 'church_event_id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(VolunteerRole::class, 'volunteer_role_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    protected function casts(): array
    {
        return [
            'slot_number' => 'integer',
            'auto_assigned' => 'boolean',
            'notified_at' => 'datetime',
        ];
    }
}
