<?php

namespace App\Filament\Resources\CommunicationProviders\Pages;

use App\Filament\Resources\CommunicationProviders\CommunicationProviderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCommunicationProviders extends ListRecords
{
    protected static string $resource = CommunicationProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
