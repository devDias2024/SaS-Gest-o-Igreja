<?php

namespace App\Filament\Resources\CellAttendances\Pages;

use App\Filament\Resources\CellAttendances\CellAttendanceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCellAttendances extends ListRecords
{
    protected static string $resource = CellAttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
