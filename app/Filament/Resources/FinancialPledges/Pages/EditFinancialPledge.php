<?php

namespace App\Filament\Resources\FinancialPledges\Pages;

use App\Filament\Resources\FinancialPledges\FinancialPledgeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFinancialPledge extends EditRecord
{
    protected static string $resource = FinancialPledgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
