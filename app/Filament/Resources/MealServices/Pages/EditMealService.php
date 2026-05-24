<?php

namespace App\Filament\Resources\MealServices\Pages;

use App\Filament\Resources\MealServices\MealServiceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMealService extends EditRecord
{
    protected static string $resource = MealServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
