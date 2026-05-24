<?php

namespace App\Filament\Resources\PanelRoles\Pages;

use App\Filament\Resources\PanelRoles\PanelRoleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPanelRoles extends ListRecords
{
    protected static string $resource = PanelRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
