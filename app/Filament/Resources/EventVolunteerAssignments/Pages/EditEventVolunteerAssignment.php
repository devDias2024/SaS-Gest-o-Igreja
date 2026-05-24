<?php

namespace App\Filament\Resources\EventVolunteerAssignments\Pages;

use App\Filament\Resources\EventVolunteerAssignments\EventVolunteerAssignmentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEventVolunteerAssignment extends EditRecord
{
    protected static string $resource = EventVolunteerAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
