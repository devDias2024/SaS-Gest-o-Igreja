<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'opening_balance', 'is_restricted', 'accepts_online_donations', 'description'])]
class Fund extends Model
{
    public function transactions(): HasMany
    {
        return $this->hasMany(FinancialTransaction::class);
    }

    public function pledges(): HasMany
    {
        return $this->hasMany(FinancialPledge::class);
    }

    public function onlineDonations(): HasMany
    {
        return $this->hasMany(OnlineDonation::class);
    }

    public function balance(): float
    {
        $income = (float) $this->transactions()->whereIn('type', ['tithe', 'offering', 'income'])->sum('amount');
        $expenses = (float) $this->transactions()->where('type', 'expense')->sum('amount');

        return (float) $this->opening_balance + $income - $expenses;
    }

    protected function casts(): array
    {
        return [
            'opening_balance' => 'decimal:2',
            'is_restricted' => 'boolean',
            'accepts_online_donations' => 'boolean',
        ];
    }
}
