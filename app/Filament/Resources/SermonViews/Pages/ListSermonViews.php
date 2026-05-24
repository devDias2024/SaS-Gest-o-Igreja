<?php

namespace App\Filament\Resources\SermonViews\Pages;

use App\Filament\Resources\SermonViews\SermonViewResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSermonViews extends ListRecords
{
    protected static string $resource = SermonViewResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
