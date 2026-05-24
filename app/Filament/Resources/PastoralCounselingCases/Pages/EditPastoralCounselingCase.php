<?php

namespace App\Filament\Resources\PastoralCounselingCases\Pages;

use App\Filament\Resources\PastoralCounselingCases\PastoralCounselingCaseResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPastoralCounselingCase extends EditRecord
{
    protected static string $resource = PastoralCounselingCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
