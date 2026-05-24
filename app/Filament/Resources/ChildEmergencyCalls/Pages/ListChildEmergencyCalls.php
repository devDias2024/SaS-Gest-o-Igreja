<?php

namespace App\Filament\Resources\ChildEmergencyCalls\Pages;

use App\Filament\Resources\ChildEmergencyCalls\ChildEmergencyCallResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListChildEmergencyCalls extends ListRecords
{
    protected static string $resource = ChildEmergencyCallResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
