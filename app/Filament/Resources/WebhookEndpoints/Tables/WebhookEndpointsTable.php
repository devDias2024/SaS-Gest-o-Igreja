<?php

namespace App\Filament\Resources\WebhookEndpoints\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WebhookEndpointsTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->label('Nome')->searchable(),
            TextColumn::make('url')->label('URL')->limit(50)->searchable(),
            TextColumn::make('events')->label('Eventos')->formatStateUsing(fn ($state): string => is_array($state) ? implode(', ', $state) : (string) $state)->badge(),
            IconColumn::make('is_active')->label('Ativo')->boolean(),
        ])->recordActions([EditAction::make()])->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
