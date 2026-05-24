<?php

namespace App\Filament\Resources\PastoralEmergencyAlerts\Pages;

use App\Filament\Resources\PastoralEmergencyAlerts\PastoralEmergencyAlertResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePastoralEmergencyAlert extends CreateRecord
{
    protected static string $resource = PastoralEmergencyAlertResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['triggered_by_user_id'] ??= auth()->id();
        $data['triggered_at'] ??= now();

        return $data;
    }
}
