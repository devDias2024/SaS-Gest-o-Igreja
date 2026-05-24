<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['cell_meeting_id', 'member_id', 'guest_name', 'status', 'checked_in_at', 'notes'])]
class CellAttendance extends Model
{
    public function meeting(): BelongsTo
    {
        return $this->belongsTo(CellMeeting::class, 'cell_meeting_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    protected function casts(): array
    {
        return [
            'checked_in_at' => 'datetime',
        ];
    }
}
