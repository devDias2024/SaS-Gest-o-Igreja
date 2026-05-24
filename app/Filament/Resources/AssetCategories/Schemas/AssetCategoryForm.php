<?php

namespace App\Filament\Resources\AssetCategories\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class AssetCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'md' => 2])
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),
                        Select::make('type')
                            ->label('Tipo')
                            ->default('asset')
                            ->required()
                            ->options([
                                'asset' => 'Patrimonio',
                                'stock' => 'Estoque',
                                'both' => 'Ambos',
                            ]),
                        Textarea::make('description')
                            ->label('Descricao')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
