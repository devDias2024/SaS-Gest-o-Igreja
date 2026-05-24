<?php

namespace App\Filament\Resources\CostCenters\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class CostCenterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Centro de custo')
                    ->tabs([
                        Tab::make('Dados')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        TextInput::make('name')->label('Nome')->required()->maxLength(255),
                                        TextInput::make('code')->label('Codigo')->maxLength(255),
                                        Toggle::make('is_active')->label('Ativo')->default(true),
                                    ]),
                            ]),
                        Tab::make('Descricao')
                            ->schema([
                                Textarea::make('description')->label('Descricao')->rows(5)->columnSpanFull(),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
