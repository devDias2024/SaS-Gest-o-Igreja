<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['teacher_id', 'name', 'course_name', 'period_label', 'starts_on', 'ends_on', 'schedule', 'room', 'status', 'minimum_attendance_percent', 'minimum_grade', 'description'])]
class SundaySchoolClass extends Model
{
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'teacher_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(SundaySchoolEnrollment::class);
    }

    protected function casts(): array
    {
        return [
            'starts_on' => 'date',
            'ends_on' => 'date',
            'minimum_grade' => 'decimal:2',
            'minimum_attendance_percent' => 'integer',
        ];
    }
}
