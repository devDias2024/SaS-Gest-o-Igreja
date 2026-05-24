<?php

namespace App\Filament\Resources\CommunicationMessages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CommunicationMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Criada')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('direction')->label('Direcao')->badge()->sortable(),
                TextColumn::make('channel')->label('Canal')->badge()->sortable(),
                TextColumn::make('member.full_name')->label('Membro')->searchable()->toggleable(),
                TextColumn::make('recipient_contact')->label('Contato')->searchable(),
                TextColumn::make('subject')->label('Assunto')->searchable()->limit(40),
                TextColumn::make('status')->label('Status')->badge()->sortable(),
                TextColumn::make('sent_at')->label('Enviada')->dateTime('d/m/Y H:i')->sortable()->toggleable(),
                TextColumn::make('opened_at')->label('Aberta')->dateTime('d/m/Y H:i')->sortable()->toggleable(),
                TextColumn::make('clicked_at')->label('Clique')->dateTime('d/m/Y H:i')->sortable()->toggleable(),
            ])
            ->filters([
                SelectFilter::make('channel')->label('Canal')->options([
                    'email' => 'E-mail',
                    'sms' => 'SMS',
                    'whatsapp' => 'WhatsApp',
                    'push' => 'Push/App',
                ]),
                SelectFilter::make('status')->label('Status')->options([
                    'queued' => 'Na fila',
                    'scheduled' => 'Agendada',
                    'sent' => 'Enviada',
                    'delivered' => 'Entregue',
                    'opened' => 'Aberta',
                    'clicked' => 'Clicada',
                    'received' => 'Recebida',
                    'failed' => 'Falhou',
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
