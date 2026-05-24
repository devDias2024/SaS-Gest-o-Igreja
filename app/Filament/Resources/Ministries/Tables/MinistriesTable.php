<?php

namespace App\Filament\Resources\Ministries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MinistriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nome')->searchable()->sortable(),
                TextColumn::make('leader.full_name')->label('Lider')->searchable()->toggleable(),
                TextColumn::make('supervisor.full_name')->label('Supervisor')->searchable()->toggleable(),
                TextColumn::make('cell_groups_count')->label('Celulas')->counts('cellGroups')->sortable(),
                TextColumn::make('goals_count')->label('Metas')->counts('goals')->sortable(),
                TextColumn::make('status')->label('Status')->badge(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'active' => 'Ativo',
                    'paused' => 'Pausado',
                    'closed' => 'Encerrado',
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
