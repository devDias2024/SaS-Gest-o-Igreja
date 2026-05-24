<?php

namespace App\Filament\Resources\PastoralSupportReferrals\Pages;

use App\Filament\Resources\PastoralSupportReferrals\PastoralSupportReferralResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPastoralSupportReferrals extends ListRecords
{
    protected static string $resource = PastoralSupportReferralResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
