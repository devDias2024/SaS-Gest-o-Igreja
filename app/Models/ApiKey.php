<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable(['name', 'key_prefix', 'key_hash', 'scopes', 'allowed_ips', 'rate_limit_per_minute', 'is_active', 'last_used_at', 'expires_at'])]
class ApiKey extends Model
{
    public static function hashToken(string $token): string
    {
        return hash('sha256', $token);
    }

    public static function generateToken(): string
    {
        return 'sk_'.Str::random(8).'_'.Str::random(40);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(ApiRequestLog::class);
    }

    public function isUsableFrom(?string $ip): bool
    {
        if (! $this->is_active || ($this->expires_at && $this->expires_at->isPast())) {
            return false;
        }

        if (! $this->allowed_ips || $this->allowed_ips === []) {
            return true;
        }

        return in_array($ip, $this->allowed_ips, true);
    }

    protected function casts(): array
    {
        return [
            'scopes' => 'array',
            'allowed_ips' => 'array',
            'rate_limit_per_minute' => 'integer',
            'is_active' => 'boolean',
            'last_used_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }
}
