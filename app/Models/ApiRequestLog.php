<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['api_key_id', 'method', 'path', 'ip_address', 'status_code', 'duration_ms', 'user_agent', 'request_payload', 'response_payload'])]
class ApiRequestLog extends Model
{
    public function apiKey(): BelongsTo
    {
        return $this->belongsTo(ApiKey::class);
    }

    protected function casts(): array
    {
        return [
            'request_payload' => 'array',
            'response_payload' => 'array',
            'duration_ms' => 'integer',
        ];
    }
}
