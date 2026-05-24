<?php

namespace App\Filament\Resources\CommunicationMessages\Pages;

use App\Filament\Resources\CommunicationMessages\CommunicationMessageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCommunicationMessages extends ListRecords
{
    protected static string $resource = CommunicationMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
