<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['sunday_school_class_id', 'member_id', 'enrolled_on', 'completed_on', 'status', 'final_grade', 'attendance_percent', 'notes'])]
class SundaySchoolEnrollment extends Model
{
    public function class(): BelongsTo
    {
        return $this->belongsTo(SundaySchoolClass::class, 'sunday_school_class_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(SundaySchoolAttendance::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(SundaySchoolGrade::class);
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(SundaySchoolCertificate::class);
    }

    public function refreshAcademicTotals(): void
    {
        $total = $this->attendances()->count();
        $present = $this->attendances()->whereIn('status', ['present', 'justified'])->count();
        $grades = $this->grades()->whereNotNull('numeric_grade')->get();
        $weight = $grades->sum('weight');

        $this->forceFill([
            'attendance_percent' => $total > 0 ? (int) round(($present / $total) * 100) : null,
            'final_grade' => $weight > 0 ? round($grades->sum(fn ($grade) => $grade->numeric_grade * $grade->weight) / $weight, 2) : null,
        ])->save();
    }

    protected function casts(): array
    {
        return [
            'enrolled_on' => 'date',
            'completed_on' => 'date',
            'final_grade' => 'decimal:2',
            'attendance_percent' => 'integer',
        ];
    }
}
