<?php

namespace App\Filament\Resources\SundaySchoolEnrollments\Pages;

use App\Filament\Resources\SundaySchoolEnrollments\SundaySchoolEnrollmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSundaySchoolEnrollments extends ListRecords
{
    protected static string $resource = SundaySchoolEnrollmentResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
