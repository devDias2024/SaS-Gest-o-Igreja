<?php

namespace App\Filament\Resources\SocialPantryDistributions\Pages;

use App\Filament\Resources\SocialPantryDistributions\SocialPantryDistributionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSocialPantryDistributions extends ListRecords
{
    protected static string $resource = SocialPantryDistributionResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
