<?php

namespace App\Filament\Resources\SermonViews\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class SermonViewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(['default' => 1, 'md' => 2])->schema([
                Select::make('sermon_id')->label('Pregacao')->relationship('sermon', 'title')->searchable()->preload()->required()->columnSpanFull(),
                Select::make('member_id')->label('Membro')->relationship('member', 'full_name')->searchable()->preload(),
                TextInput::make('viewer_name')->label('Visitante')->maxLength(255),
                TextInput::make('source')->label('Origem')->default('admin')->maxLength(255),
                TextInput::make('watched_seconds')->label('Tempo assistido (s)')->numeric()->integer()->default(0),
                DateTimePicker::make('viewed_at')->label('Visualizado em')->default(now())->required()->native(false),
            ]),
        ]);
    }
}
