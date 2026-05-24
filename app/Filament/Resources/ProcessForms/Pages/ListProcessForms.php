<?php

namespace App\Filament\Resources\ProcessForms\Pages;

use App\Filament\Resources\ProcessForms\ProcessFormResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProcessForms extends ListRecords
{
    protected static string $resource = ProcessFormResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
