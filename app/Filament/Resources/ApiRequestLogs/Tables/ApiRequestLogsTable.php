<?php

namespace App\Filament\Resources\ApiRequestLogs\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ApiRequestLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('created_at')->label('Data')->dateTime('d/m/Y H:i:s')->sortable(),
            TextColumn::make('apiKey.name')->label('Chave')->searchable(),
            TextColumn::make('method')->label('Metodo')->badge(),
            TextColumn::make('path')->label('Rota')->searchable()->limit(70),
            TextColumn::make('status_code')->label('Status')->badge()->sortable(),
            TextColumn::make('duration_ms')->label('ms')->sortable(),
            TextColumn::make('ip_address')->label('IP')->searchable(),
        ])->filters([
            SelectFilter::make('method')->label('Metodo')->options([
                'GET' => 'GET',
                'POST' => 'POST',
                'PUT' => 'PUT',
                'PATCH' => 'PATCH',
                'DELETE' => 'DELETE',
            ]),
        ])->defaultSort('created_at', 'desc');
    }
}
