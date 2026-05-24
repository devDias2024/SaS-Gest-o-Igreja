<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'sermon_id',
    'member_id',
    'author_name',
    'visibility',
    'body',
])]
class SermonNote extends Model
{
    public function sermon(): BelongsTo
    {
        return $this->belongsTo(Sermon::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
