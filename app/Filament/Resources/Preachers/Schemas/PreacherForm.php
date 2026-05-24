<?php

namespace App\Filament\Resources\Preachers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PreacherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(['default' => 1, 'md' => 2])->schema([
                TextInput::make('name')->label('Nome')->required()->live(onBlur: true)->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state)))->maxLength(255),
                TextInput::make('slug')->label('Identificador')->required()->unique(ignoreRecord: true)->maxLength(255),
                Select::make('member_id')->label('Membro vinculado')->relationship('member', 'full_name')->searchable()->preload(),
                TextInput::make('email')->label('E-mail')->email()->maxLength(255),
                TextInput::make('phone')->label('Telefone')->maxLength(255),
                Toggle::make('is_active')->label('Ativo')->default(true),
                Textarea::make('bio')->label('Biografia')->rows(5)->columnSpanFull(),
            ]),
        ]);
    }
}
