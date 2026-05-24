<?php

namespace App\Filament\Resources\FoodDonations\Pages;

use App\Filament\Resources\FoodDonations\FoodDonationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFoodDonations extends ListRecords
{
    protected static string $resource = FoodDonationResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
