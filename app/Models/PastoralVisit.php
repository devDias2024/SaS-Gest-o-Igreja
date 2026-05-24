<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'member_id',
    'cell_group_id',
    'pastor_id',
    'scheduled_at',
    'visited_at',
    'visit_type',
    'status',
    'address',
    'reason',
    'summary',
    'next_steps',
    'requires_follow_up',
    'follow_up_on',
])]
class PastoralVisit extends Model
{
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function cellGroup(): BelongsTo
    {
        return $this->belongsTo(CellGroup::class);
    }

    public function pastor(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'pastor_id');
    }

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'visited_at' => 'datetime',
            'requires_follow_up' => 'boolean',
            'follow_up_on' => 'date',
        ];
    }
}
