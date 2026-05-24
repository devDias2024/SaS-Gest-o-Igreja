<?php

namespace App\Filament\Resources\SermonNotes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SermonNotesTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('sermon.title')->label('Pregacao')->searchable()->sortable(),
            TextColumn::make('member.full_name')->label('Membro')->searchable()->placeholder('-'),
            TextColumn::make('author_name')->label('Autor')->searchable()->placeholder('-'),
            TextColumn::make('visibility')->label('Visibilidade')->badge()->formatStateUsing(fn (?string $state): string => match ($state) {
                'private' => 'Pessoal',
                'shared' => 'Compartilhada',
                default => 'Outro',
            }),
            TextColumn::make('created_at')->label('Criada em')->dateTime('d/m/Y H:i')->sortable(),
        ])->filters([
            SelectFilter::make('visibility')->label('Visibilidade')->options([
                'private' => 'Pessoal',
                'shared' => 'Compartilhada',
            ]),
        ])->recordActions([EditAction::make()])->toolbarActions([
            BulkActionGroup::make([DeleteBulkAction::make()]),
        ]);
    }
}
