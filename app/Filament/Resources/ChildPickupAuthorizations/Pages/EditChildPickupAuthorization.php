<?php

namespace App\Filament\Resources\ChildPickupAuthorizations\Pages;

use App\Filament\Resources\ChildPickupAuthorizations\ChildPickupAuthorizationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditChildPickupAuthorization extends EditRecord
{
    protected static string $resource = ChildPickupAuthorizationResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
