<?php

namespace App\Filament\Resources\ApiKeys\Pages;

use App\Filament\Resources\ApiKeys\ApiKeyResource;
use App\Models\ApiKey;
use Filament\Resources\Pages\CreateRecord;

class CreateApiKey extends CreateRecord
{
    protected static string $resource = ApiKeyResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $token = $data['plain_token'] ?? ApiKey::generateToken();
        unset($data['plain_token']);
        $data['key_prefix'] = substr($token, 0, 12);
        $data['key_hash'] = ApiKey::hashToken($token);

        return $data;
    }
}
