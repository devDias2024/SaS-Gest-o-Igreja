<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'church_event_id',
    'member_id',
    'guest_name',
    'guest_email',
    'guest_phone',
    'quantity',
    'status',
    'confirmed_at',
    'reminder_sent_at',
    'notes',
])]
class EventRegistration extends Model
{
    public function event(): BelongsTo
    {
        return $this->belongsTo(ChurchEvent::class, 'church_event_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function checkIns(): HasMany
    {
        return $this->hasMany(EventCheckIn::class);
    }

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'confirmed_at' => 'datetime',
            'reminder_sent_at' => 'datetime',
        ];
    }
}
