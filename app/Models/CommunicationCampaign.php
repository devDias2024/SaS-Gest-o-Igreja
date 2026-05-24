<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'communication_template_id',
    'name',
    'type',
    'channels',
    'status',
    'scheduled_at',
    'started_at',
    'finished_at',
    'subject',
    'body',
    'segment_filters',
    'estimated_recipients',
    'sent_count',
    'delivered_count',
    'opened_count',
    'clicked_count',
    'failed_count',
    'notes',
])]
class CommunicationCampaign extends Model
{
    public function template(): BelongsTo
    {
        return $this->belongsTo(CommunicationTemplate::class, 'communication_template_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(CommunicationMessage::class);
    }

    public function openRate(): int
    {
        if ($this->sent_count === 0) {
            return 0;
        }

        return (int) round(($this->opened_count / $this->sent_count) * 100);
    }

    protected function casts(): array
    {
        return [
            'channels' => 'array',
            'segment_filters' => 'array',
            'scheduled_at' => 'datetime',
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
            'estimated_recipients' => 'integer',
            'sent_count' => 'integer',
            'delivered_count' => 'integer',
            'opened_count' => 'integer',
            'clicked_count' => 'integer',
            'failed_count' => 'integer',
        ];
    }
}
