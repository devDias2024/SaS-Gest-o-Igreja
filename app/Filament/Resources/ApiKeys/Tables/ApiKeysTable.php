<?php

namespace App\Filament\Resources\ApiKeys\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ApiKeysTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->label('Nome')->searchable()->sortable(),
            TextColumn::make('key_prefix')->label('Prefixo'),
            TextColumn::make('rate_limit_per_minute')->label('Rate/min')->sortable(),
            IconColumn::make('is_active')->label('Ativa')->boolean(),
            TextColumn::make('last_used_at')->label('Ultimo uso')->dateTime('d/m/Y H:i')->sortable(),
            TextColumn::make('expires_at')->label('Expira')->dateTime('d/m/Y H:i')->sortable(),
        ])->recordActions([EditAction::make()])->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
