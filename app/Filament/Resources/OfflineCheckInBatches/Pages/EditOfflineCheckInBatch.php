<?php

namespace App\Filament\Resources\OfflineCheckInBatches\Pages;

use App\Filament\Resources\OfflineCheckInBatches\OfflineCheckInBatchResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOfflineCheckInBatch extends EditRecord
{
    protected static string $resource = OfflineCheckInBatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
