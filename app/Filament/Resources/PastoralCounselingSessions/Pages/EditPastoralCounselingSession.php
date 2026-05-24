<?php

namespace App\Filament\Resources\PastoralCounselingSessions\Pages;

use App\Filament\Resources\PastoralCounselingSessions\PastoralCounselingSessionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPastoralCounselingSession extends EditRecord
{
    protected static string $resource = PastoralCounselingSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
