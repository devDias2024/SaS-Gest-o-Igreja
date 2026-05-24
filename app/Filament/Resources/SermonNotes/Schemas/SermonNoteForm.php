<?php

namespace App\Filament\Resources\SermonNotes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class SermonNoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(['default' => 1, 'md' => 2])->schema([
                Select::make('sermon_id')->label('Pregacao')->relationship('sermon', 'title')->searchable()->preload()->required()->columnSpanFull(),
                Select::make('member_id')->label('Membro')->relationship('member', 'full_name')->searchable()->preload(),
                TextInput::make('author_name')->label('Autor externo')->maxLength(255),
                Select::make('visibility')->label('Visibilidade')->default('private')->required()->options([
                    'private' => 'Pessoal',
                    'shared' => 'Compartilhada',
                ]),
                Textarea::make('body')->label('Anotacao')->required()->rows(10)->columnSpanFull(),
            ]),
        ]);
    }
}
