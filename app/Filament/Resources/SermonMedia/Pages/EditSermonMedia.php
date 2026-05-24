<?php

namespace App\Filament\Resources\SermonMedia\Pages;

use App\Filament\Resources\SermonMedia\SermonMediaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSermonMedia extends EditRecord
{
    protected static string $resource = SermonMediaResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
