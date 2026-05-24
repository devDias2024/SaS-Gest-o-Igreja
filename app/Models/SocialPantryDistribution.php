<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['member_id', 'beneficiary_name', 'beneficiary_phone', 'audience_type', 'distributed_on', 'family_size', 'status', 'notes'])]
class SocialPantryDistribution extends Model
{
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(SocialPantryDistributionItem::class);
    }

    protected function casts(): array
    {
        return ['distributed_on' => 'date', 'family_size' => 'integer'];
    }
}
