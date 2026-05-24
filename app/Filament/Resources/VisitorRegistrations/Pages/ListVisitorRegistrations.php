<?php

namespace App\Filament\Resources\VisitorRegistrations\Pages;

use App\Filament\Resources\VisitorRegistrations\VisitorRegistrationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVisitorRegistrations extends ListRecords
{
    protected static string $resource = VisitorRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
