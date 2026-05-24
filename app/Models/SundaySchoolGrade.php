<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['sunday_school_enrollment_id', 'lesson_title', 'graded_on', 'grade_type', 'numeric_grade', 'concept_grade', 'weight', 'notes'])]
class SundaySchoolGrade extends Model
{
    protected static function booted(): void
    {
        static::saved(fn (self $grade) => $grade->enrollment?->refreshAcademicTotals());
        static::deleted(fn (self $grade) => $grade->enrollment?->refreshAcademicTotals());
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(SundaySchoolEnrollment::class, 'sunday_school_enrollment_id');
    }

    protected function casts(): array
    {
        return [
            'graded_on' => 'date',
            'numeric_grade' => 'decimal:2',
            'weight' => 'decimal:2',
        ];
    }
}
