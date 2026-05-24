<?php

namespace App\Filament\Resources\CellAttendances\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CellAttendancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('meeting.starts_at')->label('Data')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('meeting.cellGroup.name')->label('Celula')->searchable(),
                TextColumn::make('member.full_name')->label('Membro')->searchable()->placeholder('Visitante'),
                TextColumn::make('guest_name')->label('Visitante')->searchable()->toggleable(),
                TextColumn::make('status')->label('Status')->badge(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'present' => 'Presente',
                    'absent' => 'Ausente',
                    'justified' => 'Justificado',
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
