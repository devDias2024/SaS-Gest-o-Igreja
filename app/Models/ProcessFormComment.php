<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'process_form_submission_id',
    'user_id',
    'body',
])]
class ProcessFormComment extends Model
{
    public function submission(): BelongsTo
    {
        return $this->belongsTo(ProcessFormSubmission::class, 'process_form_submission_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
