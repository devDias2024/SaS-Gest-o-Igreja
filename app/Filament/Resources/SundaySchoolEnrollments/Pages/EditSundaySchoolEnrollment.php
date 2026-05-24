<?php

namespace App\Filament\Resources\SundaySchoolEnrollments\Pages;

use App\Filament\Resources\SundaySchoolEnrollments\SundaySchoolEnrollmentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSundaySchoolEnrollment extends EditRecord
{
    protected static string $resource = SundaySchoolEnrollmentResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
