<?php

namespace App\Filament\Resources\SermonShareLinks\Pages;

use App\Filament\Resources\SermonShareLinks\SermonShareLinkResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSermonShareLinks extends ListRecords
{
    protected static string $resource = SermonShareLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
