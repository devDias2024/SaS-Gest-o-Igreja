<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable([
    'asset_category_id',
    'asset_location_id',
    'code',
    'barcode',
    'qr_code_payload',
    'name',
    'description',
    'asset_type',
    'status',
    'condition',
    'brand',
    'model',
    'serial_number',
    'acquisition_date',
    'purchase_value',
    'residual_value',
    'useful_life_months',
    'warranty_expires_at',
    'next_maintenance_at',
    'quantity_on_hand',
    'minimum_quantity',
    'unit',
    'notes',
])]
class Asset extends Model
{
    public static function generateCode(): string
    {
        do {
            $code = 'PAT-'.now()->format('Ymd').'-'.Str::upper(Str::random(5));
        } while (static::query()->where('code', $code)->exists());

        return $code;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(AssetCategory::class, 'asset_category_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(AssetLocation::class, 'asset_location_id');
    }

    public function loans(): HasMany
    {
        return $this->hasMany(AssetLoan::class);
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(AssetMaintenance::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function currentValue(): Attribute
    {
        return Attribute::get(function (): float {
            $purchaseValue = (float) $this->purchase_value;

            if (! $this->acquisition_date || ! $this->useful_life_months || $purchaseValue <= 0) {
                return $purchaseValue;
            }

            $monthsUsed = max(0, (int) $this->acquisition_date->diffInMonths(now()));
            $depreciable = max(0, $purchaseValue - (float) $this->residual_value);
            $depreciation = min($depreciable, $depreciable * ($monthsUsed / $this->useful_life_months));

            return round(max((float) $this->residual_value, $purchaseValue - $depreciation), 2);
        });
    }

    protected function casts(): array
    {
        return [
            'acquisition_date' => 'date',
            'purchase_value' => 'decimal:2',
            'residual_value' => 'decimal:2',
            'warranty_expires_at' => 'date',
            'next_maintenance_at' => 'date',
            'quantity_on_hand' => 'decimal:2',
            'minimum_quantity' => 'decimal:2',
        ];
    }
}
