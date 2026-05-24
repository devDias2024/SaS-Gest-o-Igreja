<?php

namespace App\Filament\Resources\AssetLocations\Pages;

use App\Filament\Resources\AssetLocations\AssetLocationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAssetLocation extends EditRecord
{
    protected static string $resource = AssetLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
