<?php

namespace App\Filament\Resources\ChildEmergencyCalls\Pages;

use App\Filament\Resources\ChildEmergencyCalls\ChildEmergencyCallResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditChildEmergencyCall extends EditRecord
{
    protected static string $resource = ChildEmergencyCallResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
