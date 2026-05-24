<?php

namespace App\Filament\Resources\SundaySchoolClasses\Pages;

use App\Filament\Resources\SundaySchoolClasses\SundaySchoolClassResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSundaySchoolClasses extends ListRecords
{
    protected static string $resource = SundaySchoolClassResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
