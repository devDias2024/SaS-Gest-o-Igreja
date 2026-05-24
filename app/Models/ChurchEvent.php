<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable([
    'event_location_id',
    'title',
    'type',
    'description',
    'starts_at',
    'ends_at',
    'recurrence_type',
    'recurrence_interval',
    'recurrence_weekdays',
    'recurrence_ends_on',
    'capacity',
    'requires_registration',
    'registration_confirmation_required',
    'registration_starts_at',
    'registration_ends_at',
    'check_in_token',
    'uses_dynamic_qr_code',
    'allows_member_app_check_in',
    'allows_offline_check_in',
    'geofencing_enabled',
    'reminder_hours_before',
    'reminder_channels',
    'status',
])]
class ChurchEvent extends Model
{
    protected static function booted(): void
    {
        static::creating(function (ChurchEvent $event): void {
            $event->check_in_token ??= Str::random(40);
        });
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(EventLocation::class, 'event_location_id');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function checkIns(): HasMany
    {
        return $this->hasMany(EventCheckIn::class);
    }

    public function volunteerAssignments(): HasMany
    {
        return $this->hasMany(EventVolunteerAssignment::class);
    }

    public function checkInSessions(): HasMany
    {
        return $this->hasMany(EventCheckInSession::class);
    }

    public function offlineBatches(): HasMany
    {
        return $this->hasMany(OfflineCheckInBatch::class);
    }

    public function effectiveCapacity(): Attribute
    {
        return Attribute::get(fn (): ?int => $this->capacity ?? $this->location?->capacity);
    }

    public function confirmedRegistrationsCount(): Attribute
    {
        return Attribute::get(fn (): int => (int) $this->registrations()
            ->whereIn('status', ['confirmed', 'checked_in'])
            ->sum('quantity'));
    }

    public function availableSpots(): Attribute
    {
        return Attribute::get(function (): ?int {
            if ($this->effective_capacity === null) {
                return null;
            }

            return max(0, $this->effective_capacity - $this->confirmed_registrations_count);
        });
    }

    public function checkInUrl(): Attribute
    {
        return Attribute::get(fn (): string => url("/eventos/check-in/{$this->check_in_token}"));
    }

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'recurrence_weekdays' => 'array',
            'recurrence_ends_on' => 'date',
            'capacity' => 'integer',
            'requires_registration' => 'boolean',
            'registration_confirmation_required' => 'boolean',
            'registration_starts_at' => 'datetime',
            'registration_ends_at' => 'datetime',
            'uses_dynamic_qr_code' => 'boolean',
            'allows_member_app_check_in' => 'boolean',
            'allows_offline_check_in' => 'boolean',
            'geofencing_enabled' => 'boolean',
            'reminder_hours_before' => 'integer',
            'reminder_channels' => 'array',
        ];
    }
}
