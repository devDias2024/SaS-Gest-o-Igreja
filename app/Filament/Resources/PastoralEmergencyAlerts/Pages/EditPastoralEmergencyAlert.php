<?php

namespace App\Filament\Resources\PastoralEmergencyAlerts\Pages;

use App\Filament\Resources\PastoralEmergencyAlerts\PastoralEmergencyAlertResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPastoralEmergencyAlert extends EditRecord
{
    protected static string $resource = PastoralEmergencyAlertResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
