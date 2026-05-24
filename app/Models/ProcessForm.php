<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'title',
    'slug',
    'description',
    'template_key',
    'status',
    'access_mode',
    'published_at',
    'starts_at',
    'ends_at',
    'response_limit',
    'captcha_enabled',
    'allow_drafts',
    'redirect_url',
    'confirmation_message',
    'fields',
    'mappings',
    'automations',
    'webhooks',
])]
class ProcessForm extends Model
{
    public function submissions(): HasMany
    {
        return $this->hasMany(ProcessFormSubmission::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', 'published')
            ->where(function (Builder $query): void {
                $query->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function (Builder $query): void {
                $query->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            });
    }

    public function hasReachedResponseLimit(): bool
    {
        return filled($this->response_limit) && $this->submissions()->count() >= $this->response_limit;
    }

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'response_limit' => 'integer',
            'captcha_enabled' => 'boolean',
            'allow_drafts' => 'boolean',
            'fields' => 'array',
            'mappings' => 'array',
            'automations' => 'array',
            'webhooks' => 'array',
        ];
    }
}
