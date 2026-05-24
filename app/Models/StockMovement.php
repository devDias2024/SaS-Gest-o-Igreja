<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'asset_id',
    'from_location_id',
    'to_location_id',
    'type',
    'quantity',
    'unit_cost',
    'movement_date',
    'reference',
    'notes',
])]
class StockMovement extends Model
{
    protected static function booted(): void
    {
        static::created(function (StockMovement $movement): void {
            $asset = $movement->asset;

            if (! $asset) {
                return;
            }

            $quantity = (float) $movement->quantity;

            match ($movement->type) {
                'in' => $asset->increment('quantity_on_hand', $quantity),
                'out' => $asset->decrement('quantity_on_hand', $quantity),
                'adjustment' => $asset->update(['quantity_on_hand' => $quantity]),
                default => null,
            };

            if ($movement->type === 'transfer' && $movement->to_location_id) {
                $asset->update(['asset_location_id' => $movement->to_location_id]);
            }
        });
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function fromLocation(): BelongsTo
    {
        return $this->belongsTo(AssetLocation::class, 'from_location_id');
    }

    public function toLocation(): BelongsTo
    {
        return $this->belongsTo(AssetLocation::class, 'to_location_id');
    }

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'unit_cost' => 'decimal:2',
            'movement_date' => 'date',
        ];
    }
}
