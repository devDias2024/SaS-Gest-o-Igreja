<?php

namespace App\Filament\Resources\CommunicationTemplates\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CommunicationTemplatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nome')->searchable()->sortable(),
                TextColumn::make('channel')->label('Canal')->badge()->sortable(),
                TextColumn::make('category')->label('Categoria')->badge()->sortable(),
                TextColumn::make('provider.name')->label('Provedor')->searchable()->toggleable(),
                TextColumn::make('campaigns_count')->label('Campanhas')->counts('campaigns')->sortable(),
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
                SelectFilter::make('category')->label('Categoria')->options([
                    'welcome' => 'Boas-vindas',
                    'birthday' => 'Aniversario',
                    'absence' => 'Ausencia',
                    'event' => 'Evento',
                    'announcement' => 'Aviso',
                    'custom' => 'Personalizado',
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
