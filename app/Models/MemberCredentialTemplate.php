<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'church_name',
    'church_logo',
    'authority_name',
    'authority_title',
    'front_background',
    'back_background',
    'background_color',
    'text_color',
    'photo_shape',
    'border_shape',
    'document_type',
    'back_description',
    'show_holder_signature',
    'show_authority_signature',
    'default_validity_months',
    'is_active',
])]
class MemberCredentialTemplate extends Model
{
    public function credentials(): HasMany
    {
        return $this->hasMany(MemberCredential::class);
    }

    protected function casts(): array
    {
        return [
            'show_holder_signature' => 'boolean',
            'show_authority_signature' => 'boolean',
            'default_validity_months' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
