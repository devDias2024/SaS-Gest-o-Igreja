<?php

namespace App\Filament\Resources\CommunicationInboxThreads\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class CommunicationInboxThreadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Conversa')
                    ->tabs([
                        Tab::make('Contato')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        Select::make('member_id')->label('Membro')->relationship('member', 'full_name')->searchable()->preload(),
                                        Select::make('channel')->label('Canal')->required()->options([
                                            'email' => 'E-mail',
                                            'sms' => 'SMS',
                                            'whatsapp' => 'WhatsApp',
                                            'push' => 'Push/App',
                                        ]),
                                        Select::make('status')->label('Status')->default('open')->required()->options([
                                            'open' => 'Aberta',
                                            'pending' => 'Pendente',
                                            'closed' => 'Fechada',
                                        ]),
                                        TextInput::make('contact_name')->label('Nome do contato')->maxLength(255),
                                        TextInput::make('external_contact')->label('Contato externo')->maxLength(255),
                                        TextInput::make('unread_count')->label('Nao lidas')->numeric()->default(0),
                                    ]),
                            ]),
                        Tab::make('Resumo')
                            ->schema([
                                TextInput::make('subject')->label('Assunto')->maxLength(255)->columnSpanFull(),
                                Textarea::make('last_message_preview')->label('Ultima mensagem')->rows(4)->columnSpanFull(),
                            ]),
                        Tab::make('Metadados')
                            ->schema([
                                KeyValue::make('metadata')->label('Metadados')->columnSpanFull(),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
