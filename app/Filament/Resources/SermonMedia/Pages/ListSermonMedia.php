<?php

namespace App\Filament\Resources\SermonMedia\Pages;

use App\Filament\Resources\SermonMedia\SermonMediaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSermonMedia extends ListRecords
{
    protected static string $resource = SermonMediaResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
