<?php

namespace App\Filament\Resources\PastoralSupportReferrals\Pages;

use App\Filament\Resources\PastoralSupportReferrals\PastoralSupportReferralResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPastoralSupportReferral extends EditRecord
{
    protected static string $resource = PastoralSupportReferralResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
