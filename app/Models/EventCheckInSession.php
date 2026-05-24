<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['church_event_id', 'token', 'expires_at', 'is_active', 'metadata'])]
class EventCheckInSession extends Model
{
    public function event(): BelongsTo
    {
        return $this->belongsTo(ChurchEvent::class, 'church_event_id');
    }

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'is_active' => 'boolean',
            'metadata' => 'array',
        ];
    }
}
