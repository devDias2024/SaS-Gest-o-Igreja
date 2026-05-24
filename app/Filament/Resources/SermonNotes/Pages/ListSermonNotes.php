<?php

namespace App\Filament\Resources\SermonNotes\Pages;

use App\Filament\Resources\SermonNotes\SermonNoteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSermonNotes extends ListRecords
{
    protected static string $resource = SermonNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
