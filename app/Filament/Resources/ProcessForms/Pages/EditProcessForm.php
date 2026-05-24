<?php

namespace App\Filament\Resources\ProcessForms\Pages;

use App\Filament\Resources\ProcessForms\ProcessFormResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProcessForm extends EditRecord
{
    protected static string $resource = ProcessFormResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
