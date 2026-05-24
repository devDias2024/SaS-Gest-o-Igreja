<?php

namespace App\Filament\Resources\MemberCategories\Pages;

use App\Filament\Resources\MemberCategories\MemberCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMemberCategory extends EditRecord
{
    protected static string $resource = MemberCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
