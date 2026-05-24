<?php

namespace App\Filament\Resources\SundaySchoolClasses\Pages;

use App\Filament\Resources\SundaySchoolClasses\SundaySchoolClassResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSundaySchoolClass extends EditRecord
{
    protected static string $resource = SundaySchoolClassResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
