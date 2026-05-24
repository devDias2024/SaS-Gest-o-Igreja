<?php

namespace App\Filament\Resources\FinancialTransactions\Pages;

use App\Filament\Exports\FinancialTransactionExporter;
use App\Filament\Resources\FinancialTransactions\FinancialTransactionResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListFinancialTransactions extends ListRecords
{
    protected static string $resource = FinancialTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->label('Exportar Excel/CSV')
                ->exporter(FinancialTransactionExporter::class),
            CreateAction::make(),
        ];
    }
}
