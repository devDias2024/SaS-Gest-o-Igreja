<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'sermon_category_id',
    'sermon_series_id',
    'preacher_id',
    'title',
    'slug',
    'preached_at',
    'status',
    'visibility',
    'scripture_reference',
    'summary',
    'tags',
    'allow_download',
    'allow_sharing',
    'view_count',
    'download_count',
])]
class Sermon extends Model
{
    public function category(): BelongsTo
    {
        return $this->belongsTo(SermonCategory::class, 'sermon_category_id');
    }

    public function series(): BelongsTo
    {
        return $this->belongsTo(SermonSeries::class, 'sermon_series_id');
    }

    public function preacher(): BelongsTo
    {
        return $this->belongsTo(Preacher::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(SermonMedia::class);
    }

    public function primaryMedia(): HasOne
    {
        return $this->hasOne(SermonMedia::class)->where('is_primary', true);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(SermonNote::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(SermonView::class);
    }

    public function shareLinks(): HasMany
    {
        return $this->hasMany(SermonShareLink::class);
    }

    protected function casts(): array
    {
        return [
            'preached_at' => 'datetime',
            'tags' => 'array',
            'allow_download' => 'boolean',
            'allow_sharing' => 'boolean',
            'view_count' => 'integer',
            'download_count' => 'integer',
        ];
    }
}
