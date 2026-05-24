<?php

namespace App\Filament\Exports;

use App\Models\FinancialTransaction;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class FinancialTransactionExporter extends Exporter
{
    protected static ?string $model = FinancialTransaction::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('transaction_date')->label('Data'),
            ExportColumn::make('type')->label('Tipo'),
            ExportColumn::make('amount')->label('Valor'),
            ExportColumn::make('member.full_name')->label('Membro'),
            ExportColumn::make('category.name')->label('Categoria'),
            ExportColumn::make('costCenter.name')->label('Centro de custo'),
            ExportColumn::make('fund.name')->label('Fundo'),
            ExportColumn::make('payment_method')->label('Forma de pagamento'),
            ExportColumn::make('document_number')->label('Documento'),
            ExportColumn::make('source')->label('Origem'),
            ExportColumn::make('status')->label('Status'),
            ExportColumn::make('description')->label('Descricao'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'A exportacao financeira foi concluida com ' . Number::format($export->successful_rows) . ' ' . str('linha')->plural($export->successful_rows) . ' exportadas.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('linha')->plural($failedRowsCount) . ' falharam.';
        }

        return $body;
    }
}
