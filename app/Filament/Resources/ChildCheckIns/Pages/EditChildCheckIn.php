<?php

namespace App\Filament\Resources\ChildCheckIns\Pages;

use App\Filament\Resources\ChildCheckIns\ChildCheckInResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditChildCheckIn extends EditRecord
{
    protected static string $resource = ChildCheckInResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
