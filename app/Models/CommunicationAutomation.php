<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'communication_template_id',
    'name',
    'trigger',
    'channels',
    'conditions',
    'delay_minutes',
    'status',
    'last_run_at',
    'run_count',
    'notes',
])]
class CommunicationAutomation extends Model
{
    public function template(): BelongsTo
    {
        return $this->belongsTo(CommunicationTemplate::class, 'communication_template_id');
    }

    protected function casts(): array
    {
        return [
            'channels' => 'array',
            'conditions' => 'array',
            'delay_minutes' => 'integer',
            'last_run_at' => 'datetime',
            'run_count' => 'integer',
        ];
    }
}
