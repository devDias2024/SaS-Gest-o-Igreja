<?php

namespace App\Filament\Resources\MemberCredentials\Pages;

use App\Filament\Resources\MemberCredentials\MemberCredentialResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMemberCredentials extends ListRecords
{
    protected static string $resource = MemberCredentialResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()->label('Emitir credencial')];
    }
}
