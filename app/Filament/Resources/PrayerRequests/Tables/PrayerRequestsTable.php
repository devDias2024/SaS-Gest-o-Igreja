<?php

namespace App\Filament\Resources\PrayerRequests\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PrayerRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Recebido')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('name')->label('Pessoa')->searchable()->sortable(),
                TextColumn::make('phone')->label('Contato')->searchable()->toggleable(),
                TextColumn::make('message')->label('Pedido')->limit(65)->wrap()->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'new' => 'Novo',
                        'in_progress' => 'Em oracao',
                        'responded' => 'Acompanhado',
                        'closed' => 'Concluido',
                        default => $state,
                    }),
                TextColumn::make('responded_at')->label('Acompanhado em')->dateTime('d/m/Y H:i')->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'new' => 'Novo',
                    'in_progress' => 'Em oracao',
                    'responded' => 'Acompanhado',
                    'closed' => 'Concluido',
                ]),
            ])
            ->defaultSort('created_at', 'desc')
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
