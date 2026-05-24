<?php

namespace App\Filament\Resources\MemberCredentialTemplates\Pages;

use App\Filament\Resources\MemberCredentialTemplates\MemberCredentialTemplateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMemberCredentialTemplate extends EditRecord
{
    protected static string $resource = MemberCredentialTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
