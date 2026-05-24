<?php

namespace App\Filament\Resources\SocialPantryDistributions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SocialPantryDistributionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Familia atendida')->schema([
                Grid::make(['default' => 1, 'md' => 2])->schema([
                    Select::make('member_id')
                        ->label('Membro vinculado')
                        ->relationship('member', 'full_name')
                        ->searchable()
                        ->preload(),
                    TextInput::make('beneficiary_name')->label('Beneficiario externo')->maxLength(255),
                    TextInput::make('beneficiary_phone')->label('Telefone')->tel()->maxLength(255),
                    Select::make('audience_type')->label('Publico')->default('community')->options([
                        'member' => 'Membro',
                        'community' => 'Comunidade',
                    ])->required(),
                    DatePicker::make('distributed_on')->label('Data da entrega')->native(false)->default(now())->required(),
                    TextInput::make('family_size')->label('Pessoas na familia')->numeric()->minValue(1),
                    Select::make('status')->label('Status')->default('delivered')->options([
                        'scheduled' => 'Agendada',
                        'delivered' => 'Entregue',
                        'cancelled' => 'Cancelada',
                    ])->required(),
                    Textarea::make('notes')->label('Observacoes')->rows(3)->columnSpanFull(),
                ]),
            ])->columnSpanFull(),
            Section::make('Itens distribuidos')->schema([
                Repeater::make('items')
                    ->label('Itens')
                    ->relationship()
                    ->schema([
                        Grid::make(['default' => 1, 'md' => 5])->schema([
                            Select::make('asset_id')
                                ->label('Item do estoque')
                                ->relationship('asset', 'name')
                                ->searchable()
                                ->preload(),
                            Select::make('item_type')->label('Tipo')->default('food')->options([
                                'food' => 'Alimento',
                                'basic_basket' => 'Cesta basica',
                                'clothes' => 'Agasalho/roupa',
                                'toys' => 'Brinquedo',
                                'hygiene' => 'Higiene',
                                'other' => 'Outro',
                            ])->required(),
                            TextInput::make('name')->label('Nome do item')->required()->maxLength(255),
                            TextInput::make('quantity')->label('Quantidade')->numeric()->default(1)->required(),
                            TextInput::make('unit')->label('Unidade')->default('un')->maxLength(20)->required(),
                        ]),
                    ])
                    ->defaultItems(1)
                    ->addActionLabel('Adicionar item')
                    ->columnSpanFull(),
            ])->columnSpanFull(),
        ]);
    }
}
