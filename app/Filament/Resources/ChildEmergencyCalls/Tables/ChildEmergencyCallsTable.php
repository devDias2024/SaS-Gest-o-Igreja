<?php

namespace App\Filament\Resources\ChildEmergencyCalls\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ChildEmergencyCallsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Criada')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('child.full_name')->label('Crianca')->searchable()->sortable(),
                TextColumn::make('guardian.name')->label('Responsavel')->searchable(),
                TextColumn::make('channel')->label('Canal')->badge()->sortable(),
                TextColumn::make('recipient_phone')->label('Destino')->searchable(),
                TextColumn::make('status')->label('Status')->badge()->sortable(),
                TextColumn::make('sent_at')->label('Enviada')->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'pending' => 'Pendente',
                    'sent' => 'Enviada',
                    'acknowledged' => 'Confirmada',
                    'failed' => 'Falhou',
                ]),
            ])
            ->recordActions([
                Action::make('markSent')
                    ->label('Marcar enviada')
                    ->icon('heroicon-o-bell')
                    ->action(fn ($record) => $record->update(['status' => 'sent', 'sent_at' => now()])),
                Action::make('acknowledge')
                    ->label('Confirmar')
                    ->icon('heroicon-o-shield-check')
                    ->action(fn ($record) => $record->update(['status' => 'acknowledged', 'acknowledged_at' => now()])),
                EditAction::make(),
            ])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
