<?php

namespace App\Filament\Resources\MemberCategories\Pages;

use App\Filament\Resources\MemberCategories\MemberCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMemberCategory extends CreateRecord
{
    protected static string $resource = MemberCategoryResource::class;
}
