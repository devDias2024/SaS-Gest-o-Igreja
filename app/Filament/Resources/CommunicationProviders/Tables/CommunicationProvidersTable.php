<?php

namespace App\Filament\Resources\CommunicationProviders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CommunicationProvidersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nome')->searchable()->sortable(),
                TextColumn::make('channel')->label('Canal')->badge()->sortable(),
                TextColumn::make('driver')->label('Integracao')->badge()->toggleable(),
                TextColumn::make('sender_address')->label('Remetente')->searchable()->toggleable(),
                TextColumn::make('templates_count')->label('Templates')->counts('templates')->sortable(),
                TextColumn::make('messages_count')->label('Mensagens')->counts('messages')->sortable(),
                IconColumn::make('is_active')->label('Ativo')->boolean(),
            ])
            ->filters([
                SelectFilter::make('channel')->label('Canal')->options([
                    'email' => 'E-mail',
                    'sms' => 'SMS',
                    'whatsapp' => 'WhatsApp',
                    'push' => 'Push/App',
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
