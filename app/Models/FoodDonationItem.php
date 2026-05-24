<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['food_donation_id', 'asset_id', 'name', 'quantity', 'unit', 'expires_on', 'is_perishable'])]
class FoodDonationItem extends Model
{
    protected static function booted(): void
    {
        static::created(function (self $item): void {
            if ($item->asset_id) {
                StockMovement::query()->create(['asset_id' => $item->asset_id, 'type' => 'in', 'quantity' => $item->quantity, 'movement_date' => $item->donation?->donated_on ?? now(), 'reference' => 'Doacao alimentos #'.$item->food_donation_id, 'notes' => $item->name]);
            }
        });
    }

    public function donation(): BelongsTo
    {
        return $this->belongsTo(FoodDonation::class, 'food_donation_id');
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    protected function casts(): array
    {
        return ['quantity' => 'decimal:2', 'expires_on' => 'date', 'is_perishable' => 'boolean'];
    }
}
