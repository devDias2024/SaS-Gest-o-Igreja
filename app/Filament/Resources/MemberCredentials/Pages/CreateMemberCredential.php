<?php

namespace App\Filament\Resources\MemberCredentials\Pages;

use App\Filament\Resources\MemberCredentials\MemberCredentialResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMemberCredential extends CreateRecord
{
    protected static string $resource = MemberCredentialResource::class;

    protected function getRedirectUrl(): string
    {
        return route('credentials.print', $this->record);
    }
}
