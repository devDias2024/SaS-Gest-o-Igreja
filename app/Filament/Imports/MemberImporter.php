<?php

namespace App\Filament\Imports;

use App\Models\Member;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class MemberImporter extends Importer
{
    protected static ?string $model = Member::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('full_name')
                ->label('Nome completo')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->guess(['nome', 'nome completo', 'full_name']),
            ImportColumn::make('preferred_name')->label('Apelido')->rules(['nullable', 'max:255']),
            ImportColumn::make('birth_date')->label('Nascimento')->rules(['nullable', 'date']),
            ImportColumn::make('gender')->label('Genero')->rules(['nullable', 'max:255']),
            ImportColumn::make('marital_status')->label('Estado civil')->rules(['nullable', 'max:255']),
            ImportColumn::make('email')->label('E-mail')->rules(['nullable', 'email', 'max:255']),
            ImportColumn::make('phone')->label('Telefone')->rules(['nullable', 'max:255']),
            ImportColumn::make('whatsapp')->label('WhatsApp')->rules(['nullable', 'max:255']),
            ImportColumn::make('document_type')->label('Tipo documento')->rules(['nullable', 'max:255']),
            ImportColumn::make('document_number')->label('Numero documento')->rules(['nullable', 'max:255']),
            ImportColumn::make('address_zip_code')->label('CEP')->rules(['nullable', 'max:255']),
            ImportColumn::make('address_street')->label('Rua')->rules(['nullable', 'max:255']),
            ImportColumn::make('address_number')->label('Numero')->rules(['nullable', 'max:255']),
            ImportColumn::make('address_neighborhood')->label('Bairro')->rules(['nullable', 'max:255']),
            ImportColumn::make('address_city')->label('Cidade')->rules(['nullable', 'max:255']),
            ImportColumn::make('address_state')->label('UF')->rules(['nullable', 'max:2']),
            ImportColumn::make('latitude')->label('Latitude')->numeric()->rules(['nullable', 'numeric']),
            ImportColumn::make('longitude')->label('Longitude')->numeric()->rules(['nullable', 'numeric']),
            ImportColumn::make('conversion_date')->label('Conversao')->rules(['nullable', 'date']),
            ImportColumn::make('baptism_date')->label('Batismo')->rules(['nullable', 'date']),
            ImportColumn::make('ministry_role')->label('Cargo')->rules(['nullable', 'max:255']),
            ImportColumn::make('spiritual_status')->label('Situacao')->rules(['nullable', 'max:255']),
        ];
    }

    public function resolveRecord(): Member
    {
        if (($this->data['document_number'] ?? null) !== null) {
            return Member::firstOrNew([
                'document_number' => $this->data['document_number'],
            ]);
        }

        if (($this->data['email'] ?? null) !== null) {
            return Member::firstOrNew([
                'email' => $this->data['email'],
            ]);
        }

        return new Member();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'A importacao de membros foi concluida com ' . Number::format($import->successful_rows) . ' ' . str('linha')->plural($import->successful_rows) . ' importadas.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('linha')->plural($failedRowsCount) . ' falharam.';
        }

        return $body;
    }
}
