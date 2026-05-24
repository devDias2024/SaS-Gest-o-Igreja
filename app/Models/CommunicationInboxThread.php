<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'member_id',
    'channel',
    'external_contact',
    'contact_name',
    'subject',
    'status',
    'unread_count',
    'last_message_at',
    'last_message_preview',
    'metadata',
])]
class CommunicationInboxThread extends Model
{
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(CommunicationMessage::class);
    }

    protected function casts(): array
    {
        return [
            'unread_count' => 'integer',
            'last_message_at' => 'datetime',
            'metadata' => 'array',
        ];
    }
}
