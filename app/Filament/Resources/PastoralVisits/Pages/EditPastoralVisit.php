<?php

namespace App\Filament\Resources\PastoralVisits\Pages;

use App\Filament\Resources\PastoralVisits\PastoralVisitResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPastoralVisit extends EditRecord
{
    protected static string $resource = PastoralVisitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
