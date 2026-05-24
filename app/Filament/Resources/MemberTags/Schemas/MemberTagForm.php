<?php

namespace App\Filament\Resources\MemberTags\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class MemberTagForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tag')
                    ->tabs([
                        Tab::make('Dados')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Nome')
                                            ->required()
                                            ->maxLength(255),
                                        Select::make('color')
                                            ->label('Cor')
                                            ->required()
                                            ->options([
                                                'gray' => 'Cinza',
                                                'danger' => 'Vermelho',
                                                'info' => 'Azul',
                                                'success' => 'Verde',
                                                'warning' => 'Amarelo',
                                                'primary' => 'Destaque',
                                                'secondary' => 'Secundária',
                                                'amber' => 'Âmbar',
                                                'emerald' => 'Esmeralda',
                                                'cyan' => 'Ciano',
                                                'violet' => 'Violeta',
                                                'rose' => 'Rosa',
                                                'teal' => 'Turquesa',
                                            ])
                                            ->default('gray'),
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
