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
    'planned_visit_on',
    'preferred_service',
    'party_size',
    'notes',
    'status',
    'contacted_at',
    'metadata',
])]
class VisitorRegistration extends Model
{
    public function inboxThread(): BelongsTo
    {
        return $this->belongsTo(CommunicationInboxThread::class, 'communication_inbox_thread_id');
    }

    protected function casts(): array
    {
        return [
            'planned_visit_on' => 'date',
            'party_size' => 'integer',
            'contacted_at' => 'datetime',
            'metadata' => 'array',
        ];
    }
}
