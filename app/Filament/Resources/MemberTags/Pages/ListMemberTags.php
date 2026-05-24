<?php

namespace App\Filament\Resources\MemberTags\Pages;

use App\Filament\Resources\MemberTags\MemberTagResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMemberTags extends ListRecords
{
    protected static string $resource = MemberTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
