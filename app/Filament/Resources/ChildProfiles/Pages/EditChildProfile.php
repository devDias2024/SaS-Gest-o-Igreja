<?php

namespace App\Filament\Resources\ChildProfiles\Pages;

use App\Filament\Resources\ChildProfiles\ChildProfileResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditChildProfile extends EditRecord
{
    protected static string $resource = ChildProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
