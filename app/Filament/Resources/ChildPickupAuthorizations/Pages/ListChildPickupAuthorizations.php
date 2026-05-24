<?php

namespace App\Filament\Resources\ChildPickupAuthorizations\Pages;

use App\Filament\Resources\ChildPickupAuthorizations\ChildPickupAuthorizationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListChildPickupAuthorizations extends ListRecords
{
    protected static string $resource = ChildPickupAuthorizationResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
