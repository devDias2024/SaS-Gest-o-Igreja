<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

#[Fillable([
    'member_id',
    'member_credential_template_id',
    'code',
    'validation_token',
    'title',
    'blood_type',
    'issued_on',
    'expires_on',
    'status',
    'issuance_registered',
    'notes',
])]
class MemberCredential extends Model
{
    protected static function booted(): void
    {
        static::creating(function (self $credential): void {
            $credential->code ??= static::generateCode();
            $credential->validation_token ??= Str::ulid()->toBase32();
            $credential->issued_on ??= now()->toDateString();
            $credential->member_credential_template_id ??= MemberCredentialTemplate::query()
                ->where('is_active', true)
                ->value('id');

            if (! $credential->expires_on) {
                $months = MemberCredentialTemplate::query()
                    ->find($credential->member_credential_template_id)
                    ?->default_validity_months ?? 12;

                $credential->expires_on = now()->addMonths($months)->toDateString();
            }
        });
    }

    public static function generateCode(): string
    {
        $next = static::query()->count() + 1;

        do {
            $code = 'CRD-'.now()->format('Y').'-'.str_pad((string) $next++, 6, '0', STR_PAD_LEFT);
        } while (static::query()->where('code', $code)->exists());

        return $code;
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(MemberCredentialTemplate::class, 'member_credential_template_id');
    }

    public function isValid(): bool
    {
        return $this->status === 'active' && (! $this->expires_on || $this->expires_on->endOfDay()->gte(now()));
    }

    protected function casts(): array
    {
        return [
            'issued_on' => 'date',
            'expires_on' => 'date',
            'issuance_registered' => 'boolean',
        ];
    }
}
