<?php

namespace App\Filament\Resources\EventCheckIns\Pages;

use App\Filament\Resources\EventCheckIns\EventCheckInResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEventCheckIn extends EditRecord
{
    protected static string $resource = EventCheckInResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
