<?php

namespace App\Filament\Resources\PastoralCounselingCases\Pages;

use App\Filament\Resources\PastoralCounselingCases\PastoralCounselingCaseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPastoralCounselingCases extends ListRecords
{
    protected static string $resource = PastoralCounselingCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
