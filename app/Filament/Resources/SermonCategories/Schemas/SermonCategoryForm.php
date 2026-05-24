<?php

namespace App\Filament\Resources\SermonCategories\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class SermonCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(['default' => 1, 'md' => 2])->schema([
                TextInput::make('name')->label('Nome')->required()->live(onBlur: true)->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state)))->maxLength(255),
                TextInput::make('slug')->label('Identificador')->required()->unique(ignoreRecord: true)->maxLength(255),
                Toggle::make('is_active')->label('Ativa')->default(true),
                Textarea::make('description')->label('Descricao')->rows(4)->columnSpanFull(),
            ]),
        ]);
    }
}
