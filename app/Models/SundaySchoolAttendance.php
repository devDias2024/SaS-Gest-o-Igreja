<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['sunday_school_enrollment_id', 'lesson_date', 'lesson_title', 'status', 'notes'])]
class SundaySchoolAttendance extends Model
{
    protected static function booted(): void
    {
        static::saved(fn (self $attendance) => $attendance->enrollment?->refreshAcademicTotals());
        static::deleted(fn (self $attendance) => $attendance->enrollment?->refreshAcademicTotals());
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(SundaySchoolEnrollment::class, 'sunday_school_enrollment_id');
    }

    protected function casts(): array
    {
        return ['lesson_date' => 'date'];
    }
}
