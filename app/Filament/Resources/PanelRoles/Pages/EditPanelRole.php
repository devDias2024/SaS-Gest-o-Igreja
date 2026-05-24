<?php

namespace App\Filament\Resources\PanelRoles\Pages;

use App\Filament\Resources\PanelRoles\PanelRoleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPanelRole extends EditRecord
{
    protected static string $resource = PanelRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
