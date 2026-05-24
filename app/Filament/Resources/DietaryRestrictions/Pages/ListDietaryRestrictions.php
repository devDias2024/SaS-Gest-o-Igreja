<?php

namespace App\Filament\Resources\DietaryRestrictions\Pages;

use App\Filament\Resources\DietaryRestrictions\DietaryRestrictionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDietaryRestrictions extends ListRecords
{
    protected static string $resource = DietaryRestrictionResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
