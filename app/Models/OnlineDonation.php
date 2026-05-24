<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'member_id',
    'fund_id',
    'financial_transaction_id',
    'donor_name',
    'donor_email',
    'donor_phone',
    'amount',
    'payment_gateway',
    'gateway_reference',
    'payment_method',
    'status',
    'is_anonymous',
    'paid_at',
    'receipt_sent_at',
    'payload',
])]
class OnlineDonation extends Model
{
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function fund(): BelongsTo
    {
        return $this->belongsTo(Fund::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(FinancialTransaction::class, 'financial_transaction_id');
    }

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'is_anonymous' => 'boolean',
            'paid_at' => 'datetime',
            'receipt_sent_at' => 'datetime',
            'payload' => 'array',
        ];
    }
}
