<?php

namespace App\Filament\Resources\ChildProfiles\Pages;

use App\Filament\Resources\ChildProfiles\ChildProfileResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListChildProfiles extends ListRecords
{
    protected static string $resource = ChildProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
