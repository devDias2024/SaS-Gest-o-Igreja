<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'church_event_id',
    'device_id',
    'uploaded_by',
    'payload',
    'records_count',
    'processed_count',
    'failed_count',
    'status',
    'processed_at',
    'error_message',
])]
class OfflineCheckInBatch extends Model
{
    public function event(): BelongsTo
    {
        return $this->belongsTo(ChurchEvent::class, 'church_event_id');
    }

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'records_count' => 'integer',
            'processed_count' => 'integer',
            'failed_count' => 'integer',
            'processed_at' => 'datetime',
        ];
    }
}
