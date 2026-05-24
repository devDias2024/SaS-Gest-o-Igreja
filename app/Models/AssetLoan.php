<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'asset_id',
    'member_id',
    'borrower_name',
    'borrower_contact',
    'loaned_at',
    'due_at',
    'returned_at',
    'status',
    'condition_out',
    'condition_in',
    'notes',
])]
class AssetLoan extends Model
{
    protected static function booted(): void
    {
        static::saved(function (AssetLoan $loan): void {
            if (! $loan->asset) {
                return;
            }

            $loan->asset->update([
                'status' => $loan->returned_at || $loan->status === 'returned' ? 'available' : 'loaned',
            ]);
        });
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    protected function casts(): array
    {
        return [
            'loaned_at' => 'date',
            'due_at' => 'date',
            'returned_at' => 'date',
        ];
    }
}
