<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'cell_group_id',
    'host_member_id',
    'starts_at',
    'ends_at',
    'type',
    'theme',
    'status',
    'visitors_count',
    'offerings_cents',
    'notes',
])]
class CellMeeting extends Model
{
    public function cellGroup(): BelongsTo
    {
        return $this->belongsTo(CellGroup::class);
    }

    public function hostMember(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'host_member_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(CellAttendance::class);
    }

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'visitors_count' => 'integer',
            'offerings_cents' => 'integer',
        ];
    }
}
