<?php

namespace App\Filament\Resources\OfflineCheckInBatches\Pages;

use App\Filament\Resources\OfflineCheckInBatches\OfflineCheckInBatchResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOfflineCheckInBatches extends ListRecords
{
    protected static string $resource = OfflineCheckInBatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
