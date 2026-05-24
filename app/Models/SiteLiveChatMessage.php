<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'message',
    'is_approved',
    'ip_address',
    'user_agent',
])]
class SiteLiveChatMessage extends Model
{
    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
        ];
    }
}
