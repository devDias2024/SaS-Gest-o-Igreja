<?php

namespace App\Filament\Resources\Preachers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PreachersTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->label('Pregador')->searchable()->sortable(),
            TextColumn::make('member.full_name')->label('Membro')->searchable()->placeholder('-'),
            TextColumn::make('email')->label('E-mail')->searchable()->toggleable(),
            TextColumn::make('sermons_count')->label('Pregacoes')->counts('sermons')->sortable(),
            IconColumn::make('is_active')->label('Ativo')->boolean(),
        ])->recordActions([EditAction::make()])->toolbarActions([
            BulkActionGroup::make([DeleteBulkAction::make()]),
        ]);
    }
}
