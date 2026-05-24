<?php

namespace App\Filament\Resources\PastoralCounselingCases\Pages;

use App\Filament\Resources\PastoralCounselingCases\PastoralCounselingCaseResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePastoralCounselingCase extends CreateRecord
{
    protected static string $resource = PastoralCounselingCaseResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['primary_pastor_user_id'] ??= auth()->id();
        $data['opened_at'] ??= now();

        return $data;
    }
}
