<?php

namespace App\Filament\Resources\CellMemberships\Pages;

use App\Filament\Resources\CellMemberships\CellMembershipResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCellMembership extends EditRecord
{
    protected static string $resource = CellMembershipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
