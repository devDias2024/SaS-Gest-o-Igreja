<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'process_form_id',
    'member_id',
    'visitor_registration_id',
    'submitter_name',
    'submitter_email',
    'submitter_phone',
    'status',
    'answers',
    'files',
    'internal_notes',
    'submitted_at',
    'completed_at',
    'ip_address',
    'user_agent',
])]
class ProcessFormSubmission extends Model
{
    public function form(): BelongsTo
    {
        return $this->belongsTo(ProcessForm::class, 'process_form_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function visitorRegistration(): BelongsTo
    {
        return $this->belongsTo(VisitorRegistration::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ProcessFormComment::class);
    }

    protected function casts(): array
    {
        return [
            'answers' => 'array',
            'files' => 'array',
            'submitted_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }
}
