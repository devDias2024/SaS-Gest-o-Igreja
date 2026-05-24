<?php

namespace App\Filament\Resources\CommunicationAutomations\Pages;

use App\Filament\Resources\CommunicationAutomations\CommunicationAutomationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCommunicationAutomations extends ListRecords
{
    protected static string $resource = CommunicationAutomationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
