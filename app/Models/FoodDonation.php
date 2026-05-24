<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['donor_member_id', 'donor_name', 'donor_phone', 'donated_on', 'status', 'notes'])]
class FoodDonation extends Model
{
    public function donorMember(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'donor_member_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(FoodDonationItem::class);
    }

    protected function casts(): array
    {
        return ['donated_on' => 'date'];
    }
}
