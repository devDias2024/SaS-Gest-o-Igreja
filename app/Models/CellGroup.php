<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'ministry_id',
    'leader_id',
    'supervisor_id',
    'name',
    'status',
    'meeting_day',
    'meeting_time',
    'host_name',
    'address',
    'neighborhood',
    'city',
    'state',
    'latitude',
    'longitude',
    'capacity',
    'started_on',
    'description',
])]
class CellGroup extends Model
{
    public function ministry(): BelongsTo
    {
        return $this->belongsTo(Ministry::class);
    }

    public function leader(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'leader_id');
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'supervisor_id');
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(CellMembership::class);
    }

    public function meetings(): HasMany
    {
        return $this->hasMany(CellMeeting::class);
    }

    public function goals(): HasMany
    {
        return $this->hasMany(MinistryGoal::class);
    }

    public function mapUrl(): Attribute
    {
        return Attribute::get(fn (): ?string => ($this->latitude && $this->longitude)
            ? "https://www.google.com/maps/search/?api=1&query={$this->latitude},{$this->longitude}"
            : null);
    }

    protected function casts(): array
    {
        return [
            'meeting_time' => 'datetime:H:i',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'capacity' => 'integer',
            'started_on' => 'date',
        ];
    }
}
