<?php

namespace App\Filament\Resources\SermonSeries\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class SermonSeriesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(['default' => 1, 'md' => 2])->schema([
                TextInput::make('title')->label('Titulo')->required()->live(onBlur: true)->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state)))->maxLength(255),
                TextInput::make('slug')->label('Identificador')->required()->unique(ignoreRecord: true)->maxLength(255),
                DatePicker::make('starts_at')->label('Inicio')->native(false),
                DatePicker::make('ends_at')->label('Fim')->native(false),
                Textarea::make('description')->label('Descricao')->rows(5)->columnSpanFull(),
            ]),
        ]);
    }
}
