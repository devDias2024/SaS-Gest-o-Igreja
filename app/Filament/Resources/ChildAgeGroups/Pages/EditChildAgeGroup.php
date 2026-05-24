<?php

namespace App\Filament\Resources\ChildAgeGroups\Pages;

use App\Filament\Resources\ChildAgeGroups\ChildAgeGroupResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditChildAgeGroup extends EditRecord
{
    protected static string $resource = ChildAgeGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
