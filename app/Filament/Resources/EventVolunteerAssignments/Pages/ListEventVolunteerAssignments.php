<?php

namespace App\Filament\Resources\EventVolunteerAssignments\Pages;

use App\Filament\Resources\EventVolunteerAssignments\EventVolunteerAssignmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEventVolunteerAssignments extends ListRecords
{
    protected static string $resource = EventVolunteerAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
