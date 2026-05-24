<?php

namespace App\Filament\Resources\SundaySchoolAttendances\Pages;

use App\Filament\Resources\SundaySchoolAttendances\SundaySchoolAttendanceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSundaySchoolAttendance extends EditRecord
{
    protected static string $resource = SundaySchoolAttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
