<?php

namespace App\Filament\Resources\SundaySchoolGrades\Pages;

use App\Filament\Resources\SundaySchoolGrades\SundaySchoolGradeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSundaySchoolGrades extends ListRecords
{
    protected static string $resource = SundaySchoolGradeResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
