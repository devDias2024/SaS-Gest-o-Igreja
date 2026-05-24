<?php

namespace App\Filament\Resources\PublicContacts\Pages;

use App\Filament\Resources\PublicContacts\PublicContactResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPublicContact extends EditRecord
{
    protected static string $resource = PublicContactResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
