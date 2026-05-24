<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'financial_transaction_id',
    'posted_at',
    'bank_account',
    'description',
    'amount',
    'reference',
    'status',
    'notes',
    'reconciled_at',
])]
class BankStatementEntry extends Model
{
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(FinancialTransaction::class, 'financial_transaction_id');
    }

    protected function casts(): array
    {
        return [
            'posted_at' => 'date',
            'amount' => 'decimal:2',
            'reconciled_at' => 'datetime',
        ];
    }
}
