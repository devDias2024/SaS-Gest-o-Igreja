<?php

namespace App\Filament\Resources\OnlineDonations\Pages;

use App\Filament\Resources\OnlineDonations\OnlineDonationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOnlineDonation extends EditRecord
{
    protected static string $resource = OnlineDonationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
