<?php

namespace App\Filament\Resources\CellGroups\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CellGroupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Celula')->searchable()->sortable(),
                TextColumn::make('leader.full_name')->label('Lider')->searchable()->toggleable(),
                TextColumn::make('supervisor.full_name')->label('Supervisor')->searchable()->toggleable(),
                TextColumn::make('neighborhood')->label('Bairro')->searchable()->toggleable(),
                TextColumn::make('memberships_count')->label('Membros')->counts('memberships')->sortable(),
                TextColumn::make('meetings_count')->label('Reunioes')->counts('meetings')->sortable(),
                TextColumn::make('map_url')->label('Mapa')->state(fn ($record): ?string => $record->map_url ? 'Abrir' : null)->url(fn ($record): ?string => $record->map_url)->openUrlInNewTab(),
                TextColumn::make('status')->label('Status')->badge(),
            ])
            ->filters([
                SelectFilter::make('ministry_id')->label('Ministerio')->relationship('ministry', 'name')->searchable()->preload(),
                SelectFilter::make('status')->label('Status')->options([
                    'active' => 'Ativa',
                    'multiplying' => 'Em multiplicacao',
                    'paused' => 'Pausada',
                    'closed' => 'Encerrada',
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
