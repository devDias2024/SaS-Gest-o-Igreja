<?php

namespace App\Filament\Resources\DiningMenus\Pages;

use App\Filament\Resources\DiningMenus\DiningMenuResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDiningMenu extends EditRecord
{
    protected static string $resource = DiningMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
