<?php

namespace App\Filament\Resources\OnlineDonations\Pages;

use App\Filament\Resources\OnlineDonations\OnlineDonationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOnlineDonations extends ListRecords
{
    protected static string $resource = OnlineDonationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
