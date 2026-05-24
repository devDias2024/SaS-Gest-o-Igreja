<?php

namespace App\Filament\Resources\SermonShareLinks\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class SermonShareLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(['default' => 1, 'md' => 2])->schema([
                Select::make('sermon_id')->label('Pregacao')->relationship('sermon', 'title')->searchable()->preload()->required()->columnSpanFull(),
                TextInput::make('label')->label('Identificacao')->maxLength(255),
                TextInput::make('token')->label('Token')->unique(ignoreRecord: true)->maxLength(255),
                Toggle::make('allow_download')->label('Permitir download por este link')->default(false),
                DateTimePicker::make('expires_at')->label('Expira em')->native(false),
                TextInput::make('view_count')->label('Visualizacoes')->numeric()->default(0),
            ]),
        ]);
    }
}
