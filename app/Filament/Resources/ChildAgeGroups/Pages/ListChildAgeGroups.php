<?php

namespace App\Filament\Resources\ChildAgeGroups\Pages;

use App\Filament\Resources\ChildAgeGroups\ChildAgeGroupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListChildAgeGroups extends ListRecords
{
    protected static string $resource = ChildAgeGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
