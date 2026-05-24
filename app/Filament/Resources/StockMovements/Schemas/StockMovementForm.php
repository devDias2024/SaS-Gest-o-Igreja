<?php

namespace App\Filament\Resources\StockMovements\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class StockMovementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Movimentacao de estoque')
                    ->tabs([
                        Tab::make('Movimentacao')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        Select::make('asset_id')
                                            ->label('Item')
                                            ->relationship('asset', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->columnSpanFull(),
                                        Select::make('type')
                                            ->label('Tipo de movimentacao')
                                            ->live()
                                            ->required()
                                            ->options([
                                                'in' => 'Entrada',
                                                'out' => 'Saida',
                                                'transfer' => 'Transferencia',
                                                'adjustment' => 'Ajuste de saldo',
                                            ]),
                                        DatePicker::make('movement_date')
                                            ->label('Data')
                                            ->default(now())
                                            ->required()
                                            ->native(false),
                                        TextInput::make('quantity')
                                            ->label('Quantidade')
                                            ->numeric()
                                            ->required(),
                                        TextInput::make('unit_cost')
                                            ->label('Custo unitario')
                                            ->numeric()
                                            ->prefix('R$')
                                            ->default(0),
                                    ]),
                            ]),
                        Tab::make('Locais')
                            ->schema([
                                Fieldset::make('Origem e destino')
                                    ->schema([
                                        Select::make('from_location_id')
                                            ->label('Origem')
                                            ->relationship('fromLocation', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->visible(fn (Get $get): bool => in_array($get('type'), ['out', 'transfer'], true)),
                                        Select::make('to_location_id')
                                            ->label('Destino')
                                            ->relationship('toLocation', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->visible(fn (Get $get): bool => in_array($get('type'), ['in', 'transfer'], true)),
                                    ])
                                    ->columns(['default' => 1, 'md' => 2]),
                            ]),
                        Tab::make('Documento')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        TextInput::make('reference')
                                            ->label('Documento/referencia')
                                            ->maxLength(255)
                                            ->columnSpanFull(),
                                        Textarea::make('notes')
                                            ->label('Observacoes')
                                            ->rows(5)
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
