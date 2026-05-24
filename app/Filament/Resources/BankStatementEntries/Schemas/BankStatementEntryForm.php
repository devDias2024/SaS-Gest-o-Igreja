<?php

namespace App\Filament\Resources\BankStatementEntries\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class BankStatementEntryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Extrato bancario')
                    ->tabs([
                        Tab::make('Lancamento bancario')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        DatePicker::make('posted_at')->label('Data')->default(now())->required()->native(false),
                                        TextInput::make('bank_account')->label('Conta')->maxLength(255),
                                        TextInput::make('description')->label('Descricao')->required()->maxLength(255),
                                        TextInput::make('amount')->label('Valor')->numeric()->prefix('R$')->required(),
                                        TextInput::make('reference')->label('Referencia')->maxLength(255),
                                        Select::make('status')->label('Status')->default('pending')->required()->options([
                                            'pending' => 'Pendente',
                                            'matched' => 'Conciliado',
                                            'ignored' => 'Ignorado',
                                        ]),
                                    ]),
                            ]),
                        Tab::make('Conciliacao')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        Select::make('financial_transaction_id')
                                            ->label('Lancamento vinculado')
                                            ->relationship('transaction', 'description')
                                            ->searchable(),
                                        DateTimePicker::make('reconciled_at')->label('Conciliado em')->native(false),
                                        Textarea::make('notes')->label('Observacoes')->rows(4)->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
