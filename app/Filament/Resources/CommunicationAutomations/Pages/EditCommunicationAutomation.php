<?php

namespace App\Filament\Resources\CommunicationAutomations\Pages;

use App\Filament\Resources\CommunicationAutomations\CommunicationAutomationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCommunicationAutomation extends EditRecord
{
    protected static string $resource = CommunicationAutomationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
