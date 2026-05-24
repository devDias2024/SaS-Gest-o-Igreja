<?php

namespace App\Filament\Resources\PastoralCounselingSessions\Pages;

use App\Filament\Resources\PastoralCounselingSessions\PastoralCounselingSessionResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePastoralCounselingSession extends CreateRecord
{
    protected static string $resource = PastoralCounselingSessionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['pastor_user_id'] ??= auth()->id();

        return $data;
    }
}
