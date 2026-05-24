<?php

namespace App\Filament\Resources\AssetMaintenances\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AssetMaintenancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asset.code')->label('Codigo')->searchable()->toggleable(),
                TextColumn::make('asset.name')->label('Bem')->searchable()->sortable(),
                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'preventive' => 'Preventiva',
                        'corrective' => 'Corretiva',
                        default => 'Outro',
                    }),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'scheduled' => 'Agendada',
                        'in_progress' => 'Em andamento',
                        'completed' => 'Concluida',
                        'canceled' => 'Cancelada',
                        default => 'Outro',
                    }),
                TextColumn::make('scheduled_at')->label('Agendada')->date('d/m/Y')->sortable(),
                TextColumn::make('completed_at')->label('Concluida')->date('d/m/Y')->sortable()->placeholder('-'),
                TextColumn::make('next_maintenance_at')->label('Proxima')->date('d/m/Y')->sortable()->toggleable(),
                TextColumn::make('cost')->label('Custo')->money('BRL')->sortable()->toggleable(),
                TextColumn::make('provider')->label('Fornecedor')->searchable()->toggleable(),
            ])
            ->filters([
                SelectFilter::make('type')->label('Tipo')->options([
                    'preventive' => 'Preventiva',
                    'corrective' => 'Corretiva',
                ]),
                SelectFilter::make('status')->label('Status')->options([
                    'scheduled' => 'Agendada',
                    'in_progress' => 'Em andamento',
                    'completed' => 'Concluida',
                    'canceled' => 'Cancelada',
                ]),
                Filter::make('due_soon')
                    ->label('Vence em ate 30 dias')
                    ->query(fn (Builder $query): Builder => $query
                        ->whereNull('completed_at')
                        ->whereBetween('scheduled_at', [now(), now()->addDays(30)])),
                Filter::make('overdue')
                    ->label('Manutencao vencida')
                    ->query(fn (Builder $query): Builder => $query
                        ->whereNull('completed_at')
                        ->whereDate('scheduled_at', '<', now())),
            ])
            ->recordActions([
                Action::make('complete')
                    ->label('Concluir')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn ($record): bool => $record->status !== 'completed')
                    ->action(fn ($record) => $record->update([
                        'completed_at' => now(),
                        'status' => 'completed',
                    ])),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
