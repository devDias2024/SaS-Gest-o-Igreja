<?php

namespace App\Filament\Resources\SermonViews\Pages;

use App\Filament\Resources\SermonViews\SermonViewResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSermonView extends EditRecord
{
    protected static string $resource = SermonViewResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
