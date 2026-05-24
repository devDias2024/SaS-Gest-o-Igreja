<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'ministry_id',
    'cell_group_id',
    'title',
    'metric',
    'target_value',
    'current_value',
    'starts_on',
    'ends_on',
    'status',
    'notes',
])]
class MinistryGoal extends Model
{
    public function ministry(): BelongsTo
    {
        return $this->belongsTo(Ministry::class);
    }

    public function cellGroup(): BelongsTo
    {
        return $this->belongsTo(CellGroup::class);
    }

    public function progressPercent(): float
    {
        if ((float) $this->target_value <= 0) {
            return 0;
        }

        return min(100, round(((float) $this->current_value / (float) $this->target_value) * 100, 2));
    }

    protected function casts(): array
    {
        return [
            'target_value' => 'decimal:2',
            'current_value' => 'decimal:2',
            'starts_on' => 'date',
            'ends_on' => 'date',
        ];
    }
}
