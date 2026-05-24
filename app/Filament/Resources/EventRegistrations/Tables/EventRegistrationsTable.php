<?php

namespace App\Filament\Resources\EventRegistrations\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EventRegistrationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('event.title')->label('Evento')->searchable()->sortable(),
                TextColumn::make('member.full_name')->label('Membro')->searchable()->placeholder('Convidado'),
                TextColumn::make('guest_name')->label('Convidado')->searchable()->toggleable(),
                TextColumn::make('quantity')->label('Qtd'),
                TextColumn::make('status')->label('Status')->badge(),
                TextColumn::make('confirmed_at')->label('Confirmada')->dateTime('d/m/Y H:i')->toggleable(),
            ])
            ->filters([
                SelectFilter::make('church_event_id')->label('Evento')->relationship('event', 'title')->searchable()->preload(),
                SelectFilter::make('status')->label('Status')->options([
                    'pending' => 'Pendente',
                    'confirmed' => 'Confirmada',
                    'checked_in' => 'Presente',
                    'canceled' => 'Cancelada',
                    'waiting_list' => 'Lista de espera',
                ]),
            ])
            ->recordActions([
                Action::make('confirm')
                    ->label('Confirmar')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn ($record): bool => $record->status === 'pending')
                    ->action(fn ($record) => $record->update(['status' => 'confirmed', 'confirmed_at' => now()])),
                Action::make('markReminderSent')
                    ->label('Lembrete enviado')
                    ->icon('heroicon-o-bell')
                    ->action(fn ($record) => $record->update(['reminder_sent_at' => now()])),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
