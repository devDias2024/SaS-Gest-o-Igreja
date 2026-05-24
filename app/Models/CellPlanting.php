<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'parent_cell_group_id',
    'new_cell_group_id',
    'leader_id',
    'supervisor_id',
    'name',
    'target_neighborhood',
    'target_city',
    'planned_start_on',
    'launched_on',
    'status',
    'initial_members_goal',
    'strategy',
    'notes',
])]
class CellPlanting extends Model
{
    public function parentCellGroup(): BelongsTo
    {
        return $this->belongsTo(CellGroup::class, 'parent_cell_group_id');
    }

    public function newCellGroup(): BelongsTo
    {
        return $this->belongsTo(CellGroup::class, 'new_cell_group_id');
    }

    public function leader(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'leader_id');
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'supervisor_id');
    }

    protected function casts(): array
    {
        return [
            'planned_start_on' => 'date',
            'launched_on' => 'date',
            'initial_members_goal' => 'integer',
        ];
    }
}
