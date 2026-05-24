<?php

namespace App\Filament\Resources\CommunicationCampaigns\Pages;

use App\Filament\Resources\CommunicationCampaigns\CommunicationCampaignResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCommunicationCampaign extends EditRecord
{
    protected static string $resource = CommunicationCampaignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
