<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'sermon_id',
    'token',
    'label',
    'allow_download',
    'expires_at',
    'view_count',
    'last_viewed_at',
])]
class SermonShareLink extends Model
{
    public function sermon(): BelongsTo
    {
        return $this->belongsTo(Sermon::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    protected function casts(): array
    {
        return [
            'allow_download' => 'boolean',
            'expires_at' => 'datetime',
            'last_viewed_at' => 'datetime',
            'view_count' => 'integer',
        ];
    }
}
