<?php

namespace App\Filament\Resources\ChurchEvents\Pages;

use App\Filament\Resources\ChurchEvents\ChurchEventResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditChurchEvent extends EditRecord
{
    protected static string $resource = ChurchEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
