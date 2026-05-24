<?php

namespace App\Filament\Resources\PrayerRequests\Pages;

use App\Filament\Resources\PrayerRequests\PrayerRequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePrayerRequest extends CreateRecord
{
    protected static string $resource = PrayerRequestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['source'] = 'prayer';
        $data['subject'] = 'Pedido de oracao pelo site';

        return $data;
    }
}
