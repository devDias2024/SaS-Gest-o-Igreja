<?php

namespace App\Filament\Resources\CellMemberships\Pages;

use App\Filament\Resources\CellMemberships\CellMembershipResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCellMemberships extends ListRecords
{
    protected static string $resource = CellMembershipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
