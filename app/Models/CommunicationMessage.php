<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'communication_campaign_id',
    'communication_template_id',
    'communication_provider_id',
    'communication_inbox_thread_id',
    'member_id',
    'direction',
    'channel',
    'recipient_name',
    'recipient_contact',
    'subject',
    'body',
    'status',
    'scheduled_at',
    'sent_at',
    'delivered_at',
    'opened_at',
    'clicked_at',
    'external_id',
    'error_message',
    'payload',
])]
class CommunicationMessage extends Model
{
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(CommunicationCampaign::class, 'communication_campaign_id');
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(CommunicationTemplate::class, 'communication_template_id');
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(CommunicationProvider::class, 'communication_provider_id');
    }

    public function inboxThread(): BelongsTo
    {
        return $this->belongsTo(CommunicationInboxThread::class, 'communication_inbox_thread_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'sent_at' => 'datetime',
            'delivered_at' => 'datetime',
            'opened_at' => 'datetime',
            'clicked_at' => 'datetime',
            'payload' => 'array',
        ];
    }
}
