<?php

namespace App\Filament\Resources\CellPlantings\Pages;

use App\Filament\Resources\CellPlantings\CellPlantingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCellPlanting extends EditRecord
{
    protected static string $resource = CellPlantingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
