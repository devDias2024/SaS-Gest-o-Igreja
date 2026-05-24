<?php

namespace App\Filament\Resources\CellPlantings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CellPlantingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Projeto')->searchable()->sortable(),
                TextColumn::make('target_neighborhood')->label('Bairro')->searchable()->toggleable(),
                TextColumn::make('leader.full_name')->label('Lider')->searchable()->toggleable(),
                TextColumn::make('parentCellGroup.name')->label('Celula mae')->toggleable(),
                TextColumn::make('planned_start_on')->label('Previsto')->date('d/m/Y')->sortable(),
                TextColumn::make('status')->label('Status')->badge(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'planning' => 'Planejamento',
                    'training' => 'Treinando lideranca',
                    'launched' => 'Plantada',
                    'paused' => 'Pausada',
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
