<?php

namespace App\Filament\Resources\SocialPantryDistributions\Pages;

use App\Filament\Resources\SocialPantryDistributions\SocialPantryDistributionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSocialPantryDistribution extends EditRecord
{
    protected static string $resource = SocialPantryDistributionResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
