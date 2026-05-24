<?php

namespace App\Filament\Resources\SundaySchoolGrades\Pages;

use App\Filament\Resources\SundaySchoolGrades\SundaySchoolGradeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSundaySchoolGrade extends EditRecord
{
    protected static string $resource = SundaySchoolGradeResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
