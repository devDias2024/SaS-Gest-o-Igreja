<?php

namespace App\Filament\Resources\OfflineCheckInBatches\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OfflineCheckInBatchesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Recebido')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('event.title')->label('Evento')->searchable()->placeholder('Nao informado'),
                TextColumn::make('device_id')->label('Dispositivo')->searchable(),
                TextColumn::make('records_count')->label('Registros'),
                TextColumn::make('processed_count')->label('Processados'),
                TextColumn::make('failed_count')->label('Falhas'),
                TextColumn::make('status')->label('Status')->badge(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'pending' => 'Pendente',
                    'processed' => 'Processado',
                    'processed_with_errors' => 'Processado com erros',
                    'failed' => 'Falhou',
                ]),
            ])
            ->recordActions([
                Action::make('markProcessed')
                    ->label('Marcar processado')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn ($record): bool => $record->status === 'pending')
                    ->action(fn ($record) => $record->update([
                        'status' => 'processed',
                        'processed_count' => $record->records_count,
                        'processed_at' => now(),
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
