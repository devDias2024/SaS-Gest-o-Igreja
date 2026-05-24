<?php

namespace App\Filament\Resources\FinancialPledges\Pages;

use App\Filament\Resources\FinancialPledges\FinancialPledgeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFinancialPledges extends ListRecords
{
    protected static string $resource = FinancialPledgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
