<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'channel',
    'driver',
    'sender_name',
    'sender_address',
    'api_base_url',
    'settings',
    'is_active',
])]
class CommunicationProvider extends Model
{
    public function templates(): HasMany
    {
        return $this->hasMany(CommunicationTemplate::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(CommunicationMessage::class);
    }

    protected function casts(): array
    {
        return [
            'settings' => 'array',
            'is_active' => 'boolean',
        ];
    }
}
