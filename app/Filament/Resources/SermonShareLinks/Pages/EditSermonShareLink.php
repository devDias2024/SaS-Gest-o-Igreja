<?php

namespace App\Filament\Resources\SermonShareLinks\Pages;

use App\Filament\Resources\SermonShareLinks\SermonShareLinkResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSermonShareLink extends EditRecord
{
    protected static string $resource = SermonShareLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
