<?php

namespace App\Filament\Resources\MinistryGoals\Pages;

use App\Filament\Resources\MinistryGoals\MinistryGoalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMinistryGoals extends ListRecords
{
    protected static string $resource = MinistryGoalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
