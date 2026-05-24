<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'communication_inbox_thread_id',
    'name',
    'email',
    'phone',
    'subject',
    'message',
    'source',
    'status',
    'responded_at',
    'metadata',
])]
class PublicContact extends Model
{
    public function inboxThread(): BelongsTo
    {
        return $this->belongsTo(CommunicationInboxThread::class, 'communication_inbox_thread_id');
    }

    protected function casts(): array
    {
        return [
            'responded_at' => 'datetime',
            'metadata' => 'array',
        ];
    }
}
