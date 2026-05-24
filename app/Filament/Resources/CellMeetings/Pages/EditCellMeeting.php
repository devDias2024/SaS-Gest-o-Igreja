<?php

namespace App\Filament\Resources\CellMeetings\Pages;

use App\Filament\Resources\CellMeetings\CellMeetingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCellMeeting extends EditRecord
{
    protected static string $resource = CellMeetingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
