<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'sermon_id',
    'member_id',
    'viewer_name',
    'source',
    'ip_address',
    'user_agent',
    'watched_seconds',
    'viewed_at',
])]
class SermonView extends Model
{
    public function sermon(): BelongsTo
    {
        return $this->belongsTo(Sermon::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    protected function casts(): array
    {
        return [
            'watched_seconds' => 'integer',
            'viewed_at' => 'datetime',
        ];
    }
}
