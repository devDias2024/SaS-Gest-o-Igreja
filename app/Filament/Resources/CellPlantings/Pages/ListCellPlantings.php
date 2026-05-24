<?php

namespace App\Filament\Resources\CellPlantings\Pages;

use App\Filament\Resources\CellPlantings\CellPlantingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCellPlantings extends ListRecords
{
    protected static string $resource = CellPlantingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
