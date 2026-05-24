<?php

namespace App\Filament\Resources\EventCheckIns\Pages;

use App\Filament\Resources\EventCheckIns\EventCheckInResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEventCheckIns extends ListRecords
{
    protected static string $resource = EventCheckInResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
