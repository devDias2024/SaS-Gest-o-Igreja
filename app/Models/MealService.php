<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['church_event_id', 'served_on', 'meal_type', 'member_count', 'community_count', 'volunteer_count', 'notes'])]
class MealService extends Model
{
    public function event(): BelongsTo
    {
        return $this->belongsTo(ChurchEvent::class, 'church_event_id');
    }

    public function getTotalServedAttribute(): int
    {
        return (int) $this->member_count + (int) $this->community_count + (int) $this->volunteer_count;
    }

    protected function casts(): array
    {
        return ['served_on' => 'date', 'member_count' => 'integer', 'community_count' => 'integer', 'volunteer_count' => 'integer'];
    }
}
