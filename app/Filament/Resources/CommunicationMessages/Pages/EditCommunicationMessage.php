<?php

namespace App\Filament\Resources\CommunicationMessages\Pages;

use App\Filament\Resources\CommunicationMessages\CommunicationMessageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCommunicationMessage extends EditRecord
{
    protected static string $resource = CommunicationMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
