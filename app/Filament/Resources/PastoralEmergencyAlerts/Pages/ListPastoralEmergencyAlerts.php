<?php

namespace App\Filament\Resources\PastoralEmergencyAlerts\Pages;

use App\Filament\Resources\PastoralEmergencyAlerts\PastoralEmergencyAlertResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPastoralEmergencyAlerts extends ListRecords
{
    protected static string $resource = PastoralEmergencyAlertResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
