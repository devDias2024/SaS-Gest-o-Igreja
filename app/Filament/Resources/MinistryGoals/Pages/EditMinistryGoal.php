<?php

namespace App\Filament\Resources\MinistryGoals\Pages;

use App\Filament\Resources\MinistryGoals\MinistryGoalResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMinistryGoal extends EditRecord
{
    protected static string $resource = MinistryGoalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
