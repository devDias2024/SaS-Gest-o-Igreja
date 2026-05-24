<?php

namespace App\Filament\Resources\Sermons\Pages;

use App\Filament\Resources\Sermons\SermonResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateSermon extends CreateRecord
{
    protected static string $resource = SermonResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']).'-'.Str::lower(Str::random(5));

        return $data;
    }
}
