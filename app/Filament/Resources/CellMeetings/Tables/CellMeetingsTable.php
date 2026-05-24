<?php

namespace App\Filament\Resources\CellMeetings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CellMeetingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('starts_at')->label('Data')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('cellGroup.name')->label('Celula')->searchable()->sortable(),
                TextColumn::make('type')->label('Tipo')->badge(),
                TextColumn::make('theme')->label('Tema')->searchable()->toggleable(),
                TextColumn::make('attendances_count')->label('Presencas')->counts('attendances')->sortable(),
                TextColumn::make('visitors_count')->label('Visitantes')->sortable(),
                TextColumn::make('status')->label('Status')->badge(),
            ])
            ->filters([
                SelectFilter::make('cell_group_id')->label('Celula')->relationship('cellGroup', 'name')->searchable()->preload(),
                SelectFilter::make('status')->label('Status')->options([
                    'scheduled' => 'Agendada',
                    'completed' => 'Realizada',
                    'canceled' => 'Cancelada',
                ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
