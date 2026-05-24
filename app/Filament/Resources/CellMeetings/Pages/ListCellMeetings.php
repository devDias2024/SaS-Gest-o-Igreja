<?php

namespace App\Filament\Resources\CellMeetings\Pages;

use App\Filament\Resources\CellMeetings\CellMeetingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCellMeetings extends ListRecords
{
    protected static string $resource = CellMeetingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
