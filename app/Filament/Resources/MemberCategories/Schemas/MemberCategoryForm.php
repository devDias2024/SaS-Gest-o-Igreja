<?php

namespace App\Filament\Resources\MemberCategories\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class MemberCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Categoria')
                    ->tabs([
                        Tab::make('Dados')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Nome')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('color')
                                            ->label('Cor')
                                            ->default('gray')
                                            ->maxLength(20),
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
