<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'sermon_id',
    'title',
    'media_type',
    'source',
    'disk',
    'file_path',
    'external_url',
    'embed_url',
    'duration_seconds',
    'file_size',
    'is_primary',
    'allow_download',
])]
class SermonMedia extends Model
{
    public function sermon(): BelongsTo
    {
        return $this->belongsTo(Sermon::class);
    }

    public function playbackUrl(): Attribute
    {
        return Attribute::get(function (): ?string {
            if ($this->source === 'upload' && $this->file_path) {
                return Storage::disk($this->disk ?: 'public')->url($this->file_path);
            }

            return $this->embed_url ?: $this->external_url;
        });
    }

    protected function casts(): array
    {
        return [
            'duration_seconds' => 'integer',
            'file_size' => 'integer',
            'is_primary' => 'boolean',
            'allow_download' => 'boolean',
        ];
    }
}
