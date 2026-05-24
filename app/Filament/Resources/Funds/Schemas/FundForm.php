<?php

namespace App\Filament\Resources\Funds\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class FundForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Fundo')
                    ->tabs([
                        Tab::make('Dados')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Nome')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state)))
                                            ->maxLength(255),
                                        TextInput::make('slug')
                                            ->label('Identificador')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('opening_balance')
                                            ->label('Saldo inicial')
                                            ->numeric()
                                            ->prefix('R$')
                                            ->default(0),
                                        Toggle::make('is_restricted')
                                            ->label('Fundo restrito')
                                            ->default(false),
                                        Toggle::make('accepts_online_donations')
                                            ->label('Aceita doacoes online')
                                            ->default(true),
                                    ]),
                            ]),
                        Tab::make('Descricao')
                            ->schema([
                                Textarea::make('description')
                                    ->label('Descricao')
                                    ->rows(5)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
