<?php

namespace App\Filament\Resources\CellAttendances\Pages;

use App\Filament\Resources\CellAttendances\CellAttendanceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCellAttendance extends EditRecord
{
    protected static string $resource = CellAttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
