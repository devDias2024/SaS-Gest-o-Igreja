<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

#[Fillable(['sunday_school_enrollment_id', 'certificate_number', 'validation_token', 'issued_on', 'status', 'signer_name', 'signer_title', 'notes'])]
class SundaySchoolCertificate extends Model
{
    protected static function booted(): void
    {
        static::creating(function (self $certificate): void {
            $certificate->certificate_number ??= 'EBD-'.now()->format('Y').'-'.str_pad((string) (self::query()->count() + 1), 5, '0', STR_PAD_LEFT);
            $certificate->validation_token ??= Str::ulid()->toBase32();
            $certificate->issued_on ??= now()->toDateString();
        });
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(SundaySchoolEnrollment::class, 'sunday_school_enrollment_id');
    }

    protected function casts(): array
    {
        return ['issued_on' => 'date'];
    }
}
