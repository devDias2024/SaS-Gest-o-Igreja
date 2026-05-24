<?php

namespace App\Filament\Resources\Assets\Schemas;

use App\Models\Asset;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class AssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Cadastro do bem')
                    ->tabs([
                        Tab::make('Identificacao')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        TextInput::make('code')
                                            ->label('Codigo patrimonial')
                                            ->default(fn (): string => Asset::generateCode())
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255),
                                        TextInput::make('barcode')
                                            ->label('Codigo de barras')
                                            ->maxLength(255),
                                        TextInput::make('qr_code_payload')
                                            ->label('Conteudo do QR Code')
                                            ->columnSpanFull()
                                            ->maxLength(65535),
                                        TextInput::make('name')
                                            ->label('Nome')
                                            ->required()
                                            ->columnSpanFull()
                                            ->maxLength(255),
                                        Select::make('asset_category_id')
                                            ->label('Categoria')
                                            ->relationship('category', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->createOptionForm([
                                                TextInput::make('name')->label('Nome')->required()->maxLength(255),
                                                Select::make('type')->label('Tipo')->default('asset')->required()->options([
                                                    'asset' => 'Patrimonio',
                                                    'stock' => 'Estoque',
                                                    'both' => 'Ambos',
                                                ]),
                                            ]),
                                        Select::make('asset_location_id')
                                            ->label('Local')
                                            ->relationship('location', 'name')
                                            ->searchable()
                                            ->preload(),
                                        Select::make('asset_type')
                                            ->label('Tipo de cadastro')
                                            ->default('asset')
                                            ->required()
                                            ->options([
                                                'asset' => 'Patrimonio',
                                                'stock' => 'Estoque',
                                                'both' => 'Patrimonio e estoque',
                                            ]),
                                        Select::make('status')
                                            ->label('Status')
                                            ->default('available')
                                            ->required()
                                            ->options([
                                                'available' => 'Disponivel',
                                                'loaned' => 'Emprestado',
                                                'maintenance' => 'Em manutencao',
                                                'inactive' => 'Inativo',
                                                'discarded' => 'Baixado',
                                            ]),
                                        Select::make('condition')
                                            ->label('Conservacao')
                                            ->default('good')
                                            ->required()
                                            ->options([
                                                'new' => 'Novo',
                                                'good' => 'Bom',
                                                'fair' => 'Regular',
                                                'damaged' => 'Danificado',
                                            ]),
                                        Textarea::make('description')
                                            ->label('Descricao')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('Compra e garantia')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        TextInput::make('brand')->label('Marca')->maxLength(255),
                                        TextInput::make('model')->label('Modelo')->maxLength(255),
                                        TextInput::make('serial_number')->label('Numero de serie')->columnSpanFull()->maxLength(255),
                                        DatePicker::make('acquisition_date')->label('Data de aquisicao')->native(false),
                                        TextInput::make('purchase_value')->label('Valor de compra')->numeric()->prefix('R$')->default(0),
                                        TextInput::make('residual_value')->label('Valor residual')->numeric()->prefix('R$')->default(0),
                                        TextInput::make('useful_life_months')->label('Vida util (meses)')->numeric()->integer(),
                                        DatePicker::make('warranty_expires_at')->label('Vencimento da garantia')->native(false),
                                        DatePicker::make('next_maintenance_at')->label('Proxima manutencao')->native(false),
                                    ]),
                            ]),
                        Tab::make('Estoque')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        TextInput::make('quantity_on_hand')->label('Saldo atual')->numeric()->default(1),
                                        TextInput::make('minimum_quantity')->label('Saldo minimo')->numeric()->default(0),
                                        TextInput::make('unit')->label('Unidade')->default('un')->maxLength(255),
                                        Textarea::make('notes')->label('Observacoes')->rows(4)->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
