<?php

namespace App\Filament\Resources\MemberCredentialTemplates\Pages;

use App\Filament\Resources\MemberCredentialTemplates\MemberCredentialTemplateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMemberCredentialTemplates extends ListRecords
{
    protected static string $resource = MemberCredentialTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
