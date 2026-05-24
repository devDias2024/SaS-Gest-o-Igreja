<?php

namespace App\Filament\Resources\PastoralVisits\Pages;

use App\Filament\Resources\PastoralVisits\PastoralVisitResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPastoralVisits extends ListRecords
{
    protected static string $resource = PastoralVisitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
