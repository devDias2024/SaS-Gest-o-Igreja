<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'member_id',
    'fund_id',
    'type',
    'monthly_amount',
    'due_day',
    'starts_on',
    'ends_on',
    'status',
    'last_reminder_sent_at',
    'notes',
])]
class FinancialPledge extends Model
{
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function fund(): BelongsTo
    {
        return $this->belongsTo(Fund::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(FinancialTransaction::class);
    }

    public function amountPaidForMonth(?int $month = null, ?int $year = null): float
    {
        $month ??= now()->month;
        $year ??= now()->year;

        return (float) $this->transactions()
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->sum('amount');
    }

    public function isFulfilledForCurrentMonth(): bool
    {
        return $this->amountPaidForMonth() >= (float) $this->monthly_amount;
    }

    protected function casts(): array
    {
        return [
            'monthly_amount' => 'decimal:2',
            'starts_on' => 'date',
            'ends_on' => 'date',
            'last_reminder_sent_at' => 'date',
        ];
    }
}
