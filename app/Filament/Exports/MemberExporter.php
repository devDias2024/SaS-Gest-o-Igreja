<?php

namespace App\Filament\Exports;

use App\Models\Member;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class MemberExporter extends Exporter
{
    protected static ?string $model = Member::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('full_name')->label('Nome completo'),
            ExportColumn::make('preferred_name')->label('Apelido'),
            ExportColumn::make('birth_date')->label('Nascimento'),
            ExportColumn::make('gender')->label('Genero'),
            ExportColumn::make('marital_status')->label('Estado civil'),
            ExportColumn::make('email')->label('E-mail'),
            ExportColumn::make('phone')->label('Telefone'),
            ExportColumn::make('whatsapp')->label('WhatsApp'),
            ExportColumn::make('document_type')->label('Tipo documento'),
            ExportColumn::make('document_number')->label('Numero documento'),
            ExportColumn::make('address_zip_code')->label('CEP'),
            ExportColumn::make('address_street')->label('Rua'),
            ExportColumn::make('address_number')->label('Numero'),
            ExportColumn::make('address_neighborhood')->label('Bairro'),
            ExportColumn::make('address_city')->label('Cidade'),
            ExportColumn::make('address_state')->label('UF'),
            ExportColumn::make('latitude')->label('Latitude'),
            ExportColumn::make('longitude')->label('Longitude'),
            ExportColumn::make('conversion_date')->label('Conversao'),
            ExportColumn::make('baptism_date')->label('Batismo'),
            ExportColumn::make('ministry_role')->label('Cargo'),
            ExportColumn::make('spiritual_status')->label('Situacao'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'A exportacao de membros foi concluida com ' . Number::format($export->successful_rows) . ' ' . str('linha')->plural($export->successful_rows) . ' exportadas.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('linha')->plural($failedRowsCount) . ' falharam.';
        }

        return $body;
    }
}
