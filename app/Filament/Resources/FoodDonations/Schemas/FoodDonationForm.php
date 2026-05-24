<?php

namespace App\Filament\Resources\FoodDonations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FoodDonationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Doador')->schema([
                Grid::make(['default' => 1, 'md' => 2])->schema([
                    Select::make('donor_member_id')
                        ->label('Membro doador')
                        ->relationship('donorMember', 'full_name')
                        ->searchable()
                        ->preload(),
                    TextInput::make('donor_name')->label('Doador externo')->maxLength(255),
                    TextInput::make('donor_phone')->label('Telefone')->tel()->maxLength(255),
                    DatePicker::make('donated_on')->label('Data da doacao')->native(false)->default(now())->required(),
                    Select::make('status')->label('Status')->default('received')->options([
                        'received' => 'Recebida',
                        'checked' => 'Conferida',
                        'stored' => 'Armazenada',
                        'discarded' => 'Descartada',
                    ])->required(),
                    Textarea::make('notes')->label('Observacoes')->rows(3)->columnSpanFull(),
                ]),
            ])->columnSpanFull(),
            Section::make('Itens doados')->schema([
                Repeater::make('items')
                    ->label('Itens')
                    ->relationship()
                    ->schema([
                        Grid::make(['default' => 1, 'md' => 4])->schema([
                            Select::make('asset_id')
                                ->label('Item do estoque')
                                ->relationship('asset', 'name')
                                ->searchable()
                                ->preload(),
                            TextInput::make('name')->label('Nome do item')->required()->maxLength(255),
                            TextInput::make('quantity')->label('Quantidade')->numeric()->default(1)->required(),
                            TextInput::make('unit')->label('Unidade')->default('un')->maxLength(20)->required(),
                            DatePicker::make('expires_on')->label('Validade')->native(false),
                            Toggle::make('is_perishable')->label('Perecivel')->default(false),
                        ]),
                    ])
                    ->columns(1)
                    ->defaultItems(1)
                    ->addActionLabel('Adicionar item')
                    ->columnSpanFull(),
            ])->columnSpanFull(),
        ]);
    }
}
