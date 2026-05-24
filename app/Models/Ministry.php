<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['leader_id', 'supervisor_id', 'name', 'type', 'status', 'started_on', 'description'])]
class Ministry extends Model
{
    public function leader(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'leader_id');
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'supervisor_id');
    }

    public function cellGroups(): HasMany
    {
        return $this->hasMany(CellGroup::class);
    }

    public function goals(): HasMany
    {
        return $this->hasMany(MinistryGoal::class);
    }

    protected function casts(): array
    {
        return [
            'started_on' => 'date',
        ];
    }
}
