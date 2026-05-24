<?php

namespace App\Filament\Resources\VolunteerRoles\Pages;

use App\Filament\Resources\VolunteerRoles\VolunteerRoleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVolunteerRoles extends ListRecords
{
    protected static string $resource = VolunteerRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
