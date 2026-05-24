<?php

namespace App\Filament\Resources\FoodDonations\Pages;

use App\Filament\Resources\FoodDonations\FoodDonationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFoodDonation extends EditRecord
{
    protected static string $resource = FoodDonationResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
