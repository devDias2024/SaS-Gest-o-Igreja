<?php

namespace App\Filament\Resources\MemberTags\Pages;

use App\Filament\Resources\MemberTags\MemberTagResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMemberTag extends EditRecord
{
    protected static string $resource = MemberTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
