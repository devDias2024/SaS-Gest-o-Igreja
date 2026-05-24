<?php

namespace App\Filament\Resources\PastoralCounselingSessions\Pages;

use App\Filament\Resources\PastoralCounselingSessions\PastoralCounselingSessionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPastoralCounselingSessions extends ListRecords
{
    protected static string $resource = PastoralCounselingSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
