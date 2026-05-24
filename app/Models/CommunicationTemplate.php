<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'communication_provider_id',
    'name',
    'slug',
    'channel',
    'category',
    'subject',
    'body',
    'variables',
    'is_active',
])]
class CommunicationTemplate extends Model
{
    public function provider(): BelongsTo
    {
        return $this->belongsTo(CommunicationProvider::class, 'communication_provider_id');
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(CommunicationCampaign::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(CommunicationMessage::class);
    }

    protected function casts(): array
    {
        return [
            'variables' => 'array',
            'is_active' => 'boolean',
        ];
    }
}
