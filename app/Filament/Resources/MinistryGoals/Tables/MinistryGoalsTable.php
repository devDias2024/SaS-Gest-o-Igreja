<?php

namespace App\Filament\Resources\MinistryGoals\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MinistryGoalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Meta')->searchable()->sortable(),
                TextColumn::make('ministry.name')->label('Ministerio')->toggleable(),
                TextColumn::make('cellGroup.name')->label('Celula')->toggleable(),
                TextColumn::make('metric')->label('Metrica')->badge(),
                TextColumn::make('progress')->label('Progresso')->state(fn ($record): string => $record->progressPercent().'%'),
                TextColumn::make('ends_on')->label('Prazo')->date('d/m/Y')->sortable(),
                TextColumn::make('status')->label('Status')->badge(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'active' => 'Ativa',
                    'reached' => 'Alcancada',
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
