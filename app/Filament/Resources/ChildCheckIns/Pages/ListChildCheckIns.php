<?php

namespace App\Filament\Resources\ChildCheckIns\Pages;

use App\Filament\Resources\ChildCheckIns\ChildCheckInResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListChildCheckIns extends ListRecords
{
    protected static string $resource = ChildCheckInResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
