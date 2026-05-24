<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'member_id',
    'financial_category_id',
    'cost_center_id',
    'fund_id',
    'financial_pledge_id',
    'type',
    'transaction_date',
    'amount',
    'payment_method',
    'document_number',
    'source',
    'is_anonymous',
    'status',
    'description',
    'receipt_sent_at',
    'reconciled_at',
])]
class FinancialTransaction extends Model
{
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(FinancialCategory::class, 'financial_category_id');
    }

    public function costCenter(): BelongsTo
    {
        return $this->belongsTo(CostCenter::class);
    }

    public function fund(): BelongsTo
    {
        return $this->belongsTo(Fund::class);
    }

    public function pledge(): BelongsTo
    {
        return $this->belongsTo(FinancialPledge::class, 'financial_pledge_id');
    }

    public function bankStatementEntry(): HasOne
    {
        return $this->hasOne(BankStatementEntry::class);
    }

    public function onlineDonation(): HasOne
    {
        return $this->hasOne(OnlineDonation::class);
    }

    public function isIncome(): bool
    {
        return in_array($this->type, ['tithe', 'offering', 'income'], true);
    }

    protected function casts(): array
    {
        return [
            'transaction_date' => 'date',
            'amount' => 'decimal:2',
            'is_anonymous' => 'boolean',
            'receipt_sent_at' => 'datetime',
            'reconciled_at' => 'datetime',
        ];
    }
}
