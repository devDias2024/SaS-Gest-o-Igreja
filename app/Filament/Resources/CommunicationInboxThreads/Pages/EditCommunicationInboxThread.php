<?php

namespace App\Filament\Resources\CommunicationInboxThreads\Pages;

use App\Filament\Resources\CommunicationInboxThreads\CommunicationInboxThreadResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCommunicationInboxThread extends EditRecord
{
    protected static string $resource = CommunicationInboxThreadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
