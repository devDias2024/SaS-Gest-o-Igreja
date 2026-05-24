<?php

namespace App\Filament\Resources\CommunicationProviders\Pages;

use App\Filament\Resources\CommunicationProviders\CommunicationProviderResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCommunicationProvider extends EditRecord
{
    protected static string $resource = CommunicationProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
