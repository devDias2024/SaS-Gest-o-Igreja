<?php

namespace App\Filament\Resources\SermonNotes\Pages;

use App\Filament\Resources\SermonNotes\SermonNoteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSermonNote extends EditRecord
{
    protected static string $resource = SermonNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
