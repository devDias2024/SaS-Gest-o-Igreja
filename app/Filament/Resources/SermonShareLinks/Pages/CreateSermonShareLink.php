<?php

namespace App\Filament\Resources\SermonShareLinks\Pages;

use App\Filament\Resources\SermonShareLinks\SermonShareLinkResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateSermonShareLink extends CreateRecord
{
    protected static string $resource = SermonShareLinkResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['token'] = $data['token'] ?: Str::random(40);

        return $data;
    }
}
