<?php

namespace App\Filament\Resources\AssetLoans\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AssetLoansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asset.code')->label('Codigo')->searchable()->toggleable(),
                TextColumn::make('asset.name')->label('Equipamento')->searchable()->sortable(),
                TextColumn::make('member.full_name')->label('Membro')->searchable()->placeholder('-'),
                TextColumn::make('borrower_name')->label('Retirado por')->searchable()->placeholder('-'),
                TextColumn::make('loaned_at')->label('Emprestimo')->date('d/m/Y')->sortable(),
                TextColumn::make('due_at')->label('Devolucao prevista')->date('d/m/Y')->sortable(),
                TextColumn::make('returned_at')->label('Devolvido em')->date('d/m/Y')->sortable()->placeholder('-'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'open' => 'Em aberto',
                        'returned' => 'Devolvido',
                        'late' => 'Atrasado',
                        'lost' => 'Extraviado',
                        default => 'Outro',
                    }),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'open' => 'Em aberto',
                    'returned' => 'Devolvido',
                    'late' => 'Atrasado',
                    'lost' => 'Extraviado',
                ]),
                Filter::make('overdue')
                    ->label('Devolucao vencida')
                    ->query(fn (Builder $query): Builder => $query
                        ->whereNull('returned_at')
                        ->whereDate('due_at', '<', now())),
                Filter::make('due_soon')
                    ->label('Devolve em ate 7 dias')
                    ->query(fn (Builder $query): Builder => $query
                        ->whereNull('returned_at')
                        ->whereBetween('due_at', [now(), now()->addDays(7)])),
            ])
            ->recordActions([
                Action::make('return')
                    ->label('Registrar devolucao')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn ($record): bool => blank($record->returned_at))
                    ->action(fn ($record) => $record->update([
                        'returned_at' => now(),
                        'status' => 'returned',
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
