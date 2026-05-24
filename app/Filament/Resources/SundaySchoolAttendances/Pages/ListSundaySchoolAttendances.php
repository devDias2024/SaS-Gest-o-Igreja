<?php

namespace App\Filament\Resources\SundaySchoolAttendances\Pages;

use App\Filament\Resources\SundaySchoolAttendances\SundaySchoolAttendanceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSundaySchoolAttendances extends ListRecords
{
    protected static string $resource = SundaySchoolAttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
