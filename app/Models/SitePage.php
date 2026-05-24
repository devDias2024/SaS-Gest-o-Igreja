<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'title',
    'slug',
    'type',
    'status',
    'menu_label',
    'menu_order',
    'show_in_menu',
    'hero_image',
    'meta_title',
    'meta_description',
    'blocks',
    'published_at',
])]
class SitePage extends Model
{
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', 'published')
            ->where(fn (Builder $query) => $query
                ->whereNull('published_at')
                ->orWhere('published_at', '<=', now()));
    }

    protected function casts(): array
    {
        return [
            'show_in_menu' => 'boolean',
            'blocks' => 'array',
            'published_at' => 'datetime',
        ];
    }
}
