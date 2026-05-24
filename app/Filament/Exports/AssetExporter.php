<?php

namespace App\Filament\Exports;

use App\Models\Asset;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class AssetExporter extends Exporter
{
    protected static ?string $model = Asset::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('code')->label('Codigo'),
            ExportColumn::make('barcode')->label('Codigo de barras'),
            ExportColumn::make('name')->label('Nome'),
            ExportColumn::make('category.name')->label('Categoria'),
            ExportColumn::make('location.name')->label('Local'),
            ExportColumn::make('asset_type')->label('Tipo'),
            ExportColumn::make('status')->label('Status'),
            ExportColumn::make('condition')->label('Conservacao'),
            ExportColumn::make('brand')->label('Marca'),
            ExportColumn::make('model')->label('Modelo'),
            ExportColumn::make('serial_number')->label('Numero de serie'),
            ExportColumn::make('acquisition_date')->label('Aquisicao'),
            ExportColumn::make('purchase_value')->label('Valor de compra'),
            ExportColumn::make('current_value')->label('Valor atual'),
            ExportColumn::make('warranty_expires_at')->label('Garantia'),
            ExportColumn::make('next_maintenance_at')->label('Proxima manutencao'),
            ExportColumn::make('quantity_on_hand')->label('Saldo'),
            ExportColumn::make('minimum_quantity')->label('Saldo minimo'),
            ExportColumn::make('unit')->label('Unidade'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'O relatorio de patrimonio foi concluido com '.Number::format($export->successful_rows).' '.str('linha')->plural($export->successful_rows).' exportadas.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('linha')->plural($failedRowsCount).' falharam.';
        }

        return $body;
    }
}
