<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['social_pantry_distribution_id', 'asset_id', 'item_type', 'name', 'quantity', 'unit'])]
class SocialPantryDistributionItem extends Model
{
    protected static function booted(): void
    {
        static::created(function (self $item): void {
            if ($item->asset_id) {
                StockMovement::query()->create(['asset_id' => $item->asset_id, 'type' => 'out', 'quantity' => $item->quantity, 'movement_date' => $item->distribution?->distributed_on ?? now(), 'reference' => 'Distribuicao social #'.$item->social_pantry_distribution_id, 'notes' => $item->name]);
            }
        });
    }

    public function distribution(): BelongsTo
    {
        return $this->belongsTo(SocialPantryDistribution::class, 'social_pantry_distribution_id');
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    protected function casts(): array
    {
        return ['quantity' => 'decimal:2'];
    }
}
