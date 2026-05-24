<?php

namespace App\Filament\Resources\CommunicationInboxThreads\Pages;

use App\Filament\Resources\CommunicationInboxThreads\CommunicationInboxThreadResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCommunicationInboxThreads extends ListRecords
{
    protected static string $resource = CommunicationInboxThreadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
