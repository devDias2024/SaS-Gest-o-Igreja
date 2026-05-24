<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'asset_id',
    'type',
    'status',
    'scheduled_at',
    'started_at',
    'completed_at',
    'cost',
    'provider',
    'description',
    'result',
    'next_maintenance_at',
])]
class AssetMaintenance extends Model
{
    protected static function booted(): void
    {
        static::saved(function (AssetMaintenance $maintenance): void {
            if (! $maintenance->asset) {
                return;
            }

            $status = match ($maintenance->status) {
                'in_progress' => 'maintenance',
                'completed' => 'available',
                default => $maintenance->asset->status,
            };

            $maintenance->asset->update([
                'status' => $status,
                'next_maintenance_at' => $maintenance->next_maintenance_at ?: $maintenance->asset->next_maintenance_at,
            ]);
        });
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'date',
            'started_at' => 'date',
            'completed_at' => 'date',
            'cost' => 'decimal:2',
            'next_maintenance_at' => 'date',
        ];
    }
}
