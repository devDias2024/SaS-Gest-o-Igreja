<?php

namespace App\Filament\Resources\ApiKeys\Pages;

use App\Filament\Resources\ApiKeys\ApiKeyResource;
use App\Models\ApiKey;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditApiKey extends EditRecord
{
    protected static string $resource = ApiKeyResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (! empty($data['plain_token'])) {
            $data['key_prefix'] = substr($data['plain_token'], 0, 12);
            $data['key_hash'] = ApiKey::hashToken($data['plain_token']);
        }

        unset($data['plain_token']);

        return $data;
    }
}
