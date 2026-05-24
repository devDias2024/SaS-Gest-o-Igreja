<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Relaticle\CustomFields\Models\Concerns\UsesCustomFields;
use Relaticle\CustomFields\Models\Contracts\HasCustomFields;

#[Fillable([
    'member_category_id',
    'full_name',
    'preferred_name',
    'birth_date',
    'gender',
    'marital_status',
    'email',
    'phone',
    'whatsapp',
    'document_type',
    'document_number',
    'address_zip_code',
    'address_street',
    'address_number',
    'address_complement',
    'address_neighborhood',
    'address_city',
    'address_state',
    'latitude',
    'longitude',
    'conversion_date',
    'baptism_date',
    'ministry_role',
    'spiritual_status',
    'photos',
    'notes',
])]
class Member extends Model implements HasCustomFields
{
    use UsesCustomFields;

    public function category(): BelongsTo
    {
        return $this->belongsTo(MemberCategory::class, 'member_category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(MemberTag::class);
    }

    public function familyLinks(): HasMany
    {
        return $this->hasMany(MemberFamilyLink::class);
    }

    public function credentials(): HasMany
    {
        return $this->hasMany(MemberCredential::class);
    }

    public function sundaySchoolEnrollments(): HasMany
    {
        return $this->hasMany(SundaySchoolEnrollment::class);
    }

    public function mapUrl(): Attribute
    {
        return Attribute::get(function (): ?string {
            if (! $this->latitude || ! $this->longitude) {
                return null;
            }

            return "https://www.google.com/maps/search/?api=1&query={$this->latitude},{$this->longitude}";
        });
    }

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'conversion_date' => 'date',
            'baptism_date' => 'date',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'photos' => 'array',
        ];
    }
}
