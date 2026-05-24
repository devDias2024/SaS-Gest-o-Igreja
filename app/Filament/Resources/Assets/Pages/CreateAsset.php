<?php

namespace App\Filament\Resources\Assets\Pages;

use App\Filament\Resources\Assets\AssetResource;
use App\Models\Asset;
use Filament\Resources\Pages\CreateRecord;

class CreateAsset extends CreateRecord
{
    protected static string $resource = AssetResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['code'] = $data['code'] ?: Asset::generateCode();
        $data['barcode'] = $data['barcode'] ?: $data['code'];
        $data['qr_code_payload'] = $data['qr_code_payload'] ?: $data['code'];

        return $data;
    }
}
