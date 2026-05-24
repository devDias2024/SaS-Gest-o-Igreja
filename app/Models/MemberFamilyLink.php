<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['member_id', 'related_member_id', 'relationship_type', 'is_emergency_contact', 'notes'])]
class MemberFamilyLink extends Model
{
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function relatedMember(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'related_member_id');
    }

    protected function casts(): array
    {
        return [
            'is_emergency_contact' => 'boolean',
        ];
    }
}
