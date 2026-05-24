<?php

namespace App\Filament\Resources\FinancialCategories\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class FinancialCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Categoria financeira')
                    ->tabs([
                        Tab::make('Dados')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        TextInput::make('name')->label('Nome')->required()->maxLength(255),
                                        Select::make('type')->label('Tipo')->required()->options([
                                            'income' => 'Receita',
                                            'expense' => 'Despesa',
                                        ]),
                                        TextInput::make('color')->label('Cor')->default('gray')->maxLength(20),
                                        Toggle::make('is_active')->label('Ativa')->default(true),
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
