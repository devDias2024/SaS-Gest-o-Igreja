<?php

namespace App\Filament\Resources\VolunteerRoles\Pages;

use App\Filament\Resources\VolunteerRoles\VolunteerRoleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVolunteerRole extends EditRecord
{
    protected static string $resource = VolunteerRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
