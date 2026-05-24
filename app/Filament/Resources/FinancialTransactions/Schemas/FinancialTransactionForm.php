<?php

namespace App\Filament\Resources\FinancialTransactions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class FinancialTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Lancamento financeiro')
                    ->tabs([
                        Tab::make('Lancamento')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        Select::make('type')
                                            ->label('Tipo')
                                            ->required()
                                            ->options([
                                                'tithe' => 'Dizimo',
                                                'offering' => 'Oferta',
                                                'income' => 'Receita',
                                                'expense' => 'Despesa',
                                            ]),
                                        DatePicker::make('transaction_date')
                                            ->label('Data')
                                            ->default(now())
                                            ->required()
                                            ->native(false),
                                        TextInput::make('amount')
                                            ->label('Valor')
                                            ->numeric()
                                            ->prefix('R$')
                                            ->required(),
                                        Select::make('member_id')
                                            ->label('Membro')
                                            ->relationship('member', 'full_name')
                                            ->searchable()
                                            ->preload(),
                                        Toggle::make('is_anonymous')
                                            ->label('Oferta anonima')
                                            ->inline(false),
                                        Select::make('status')
                                            ->label('Status')
                                            ->default('confirmed')
                                            ->required()
                                            ->options([
                                                'pending' => 'Pendente',
                                                'confirmed' => 'Confirmado',
                                                'canceled' => 'Cancelado',
                                            ]),
                                    ]),
                            ]),
                        Tab::make('Classificacao')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        Select::make('financial_category_id')
                                            ->label('Categoria')
                                            ->relationship('category', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->createOptionForm([
                                                TextInput::make('name')->label('Nome')->required()->maxLength(255),
                                                Select::make('type')->label('Tipo')->required()->options([
                                                    'income' => 'Receita',
                                                    'expense' => 'Despesa',
                                                ]),
                                            ]),
                                        Select::make('cost_center_id')
                                            ->label('Centro de custo')
                                            ->relationship('costCenter', 'name')
                                            ->searchable()
                                            ->preload(),
                                        Select::make('fund_id')
                                            ->label('Fundo')
                                            ->relationship('fund', 'name')
                                            ->searchable()
                                            ->preload(),
                                        Select::make('financial_pledge_id')
                                            ->label('Promessa vinculada')
                                            ->relationship('pledge', 'id')
                                            ->searchable(),
                                    ]),
                            ]),
                        Tab::make('Pagamento e recibo')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        Select::make('payment_method')
                                            ->label('Forma de pagamento')
                                            ->options([
                                                'cash' => 'Dinheiro',
                                                'pix' => 'Pix',
                                                'card' => 'Cartao',
                                                'bank_transfer' => 'Transferencia',
                                                'boleto' => 'Boleto',
                                            ]),
                                        TextInput::make('document_number')
                                            ->label('Documento/NSU')
                                            ->maxLength(255),
                                        Select::make('source')
                                            ->label('Origem')
                                            ->default('manual')
                                            ->options([
                                                'manual' => 'Manual',
                                                'online' => 'Online',
                                                'imported' => 'Importado',
                                            ]),
                                        DateTimePicker::make('receipt_sent_at')
                                            ->label('Recibo enviado em')
                                            ->native(false),
                                        DateTimePicker::make('reconciled_at')
                                            ->label('Conciliado em')
                                            ->native(false),
                                        Textarea::make('description')
                                            ->label('Descricao')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
