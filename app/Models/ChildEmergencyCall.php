<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'child_profile_id',
    'child_check_in_id',
    'child_guardian_id',
    'channel',
    'recipient_phone',
    'message',
    'status',
    'sent_at',
    'acknowledged_at',
])]
class ChildEmergencyCall extends Model
{
    public function child(): BelongsTo
    {
        return $this->belongsTo(ChildProfile::class, 'child_profile_id');
    }

    public function checkIn(): BelongsTo
    {
        return $this->belongsTo(ChildCheckIn::class, 'child_check_in_id');
    }

    public function guardian(): BelongsTo
    {
        return $this->belongsTo(ChildGuardian::class, 'child_guardian_id');
    }

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
            'acknowledged_at' => 'datetime',
        ];
    }
}
