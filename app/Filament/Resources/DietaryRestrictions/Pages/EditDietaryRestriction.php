<?php

namespace App\Filament\Resources\DietaryRestrictions\Pages;

use App\Filament\Resources\DietaryRestrictions\DietaryRestrictionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDietaryRestriction extends EditRecord
{
    protected static string $resource = DietaryRestrictionResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
