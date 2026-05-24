<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'child_profile_id',
    'child_guardian_id',
    'authorized_name',
    'document_number',
    'phone',
    'photo',
    'valid_from',
    'valid_until',
    'status',
    'notes',
])]
class ChildPickupAuthorization extends Model
{
    public function child(): BelongsTo
    {
        return $this->belongsTo(ChildProfile::class, 'child_profile_id');
    }

    public function guardian(): BelongsTo
    {
        return $this->belongsTo(ChildGuardian::class, 'child_guardian_id');
    }

    protected function casts(): array
    {
        return [
            'valid_from' => 'datetime',
            'valid_until' => 'datetime',
        ];
    }
}
