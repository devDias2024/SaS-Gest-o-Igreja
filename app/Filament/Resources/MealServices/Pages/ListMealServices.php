<?php

namespace App\Filament\Resources\MealServices\Pages;

use App\Filament\Resources\MealServices\MealServiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMealServices extends ListRecords
{
    protected static string $resource = MealServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
