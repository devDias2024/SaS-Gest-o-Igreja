<?php

namespace App\Filament\Resources\CommunicationInboxThreads\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CommunicationInboxThreadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('last_message_at')->label('Ultima mensagem')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('channel')->label('Canal')->badge()->sortable(),
                TextColumn::make('member.full_name')->label('Membro')->searchable()->toggleable(),
                TextColumn::make('contact_name')->label('Contato')->searchable(),
                TextColumn::make('subject')->label('Assunto')->searchable()->limit(40),
                TextColumn::make('status')->label('Status')->badge()->sortable(),
                TextColumn::make('unread_count')->label('Nao lidas')->badge()->sortable(),
                TextColumn::make('messages_count')->label('Mensagens')->counts('messages')->sortable(),
            ])
            ->filters([
                SelectFilter::make('channel')->label('Canal')->options([
                    'email' => 'E-mail',
                    'sms' => 'SMS',
                    'whatsapp' => 'WhatsApp',
                    'push' => 'Push/App',
                ]),
                SelectFilter::make('status')->label('Status')->options([
                    'open' => 'Aberta',
                    'pending' => 'Pendente',
                    'closed' => 'Fechada',
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
