<?php

namespace App\Filament\Resources\CommunicationMessages\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class CommunicationMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Mensagem')
                    ->tabs([
                        Tab::make('Envio')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        Select::make('direction')->label('Direcao')->default('outbound')->required()->options([
                                            'outbound' => 'Saida',
                                            'inbound' => 'Entrada',
                                        ]),
                                        Select::make('channel')->label('Canal')->required()->options([
                                            'email' => 'E-mail',
                                            'sms' => 'SMS',
                                            'whatsapp' => 'WhatsApp',
                                            'push' => 'Push/App',
                                        ]),
                                        Select::make('status')->label('Status')->default('queued')->required()->options([
                                            'queued' => 'Na fila',
                                            'scheduled' => 'Agendada',
                                            'sent' => 'Enviada',
                                            'delivered' => 'Entregue',
                                            'opened' => 'Aberta',
                                            'clicked' => 'Clicada',
                                            'received' => 'Recebida',
                                            'failed' => 'Falhou',
                                        ]),
                                        Select::make('communication_campaign_id')->label('Campanha')->relationship('campaign', 'name')->searchable()->preload(),
                                        Select::make('communication_template_id')->label('Template')->relationship('template', 'name')->searchable()->preload(),
                                        Select::make('communication_provider_id')->label('Provedor')->relationship('provider', 'name')->searchable()->preload(),
                                    ]),
                            ]),
                        Tab::make('Destinatario')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        Select::make('member_id')->label('Membro')->relationship('member', 'full_name')->searchable()->preload(),
                                        Select::make('communication_inbox_thread_id')->label('Conversa')->relationship('inboxThread', 'subject')->searchable()->preload(),
                                        TextInput::make('recipient_name')->label('Nome')->maxLength(255),
                                        TextInput::make('recipient_contact')->label('Contato')->maxLength(255),
                                    ]),
                            ]),
                        Tab::make('Conteudo')
                            ->schema([
                                TextInput::make('subject')->label('Assunto')->maxLength(255)->columnSpanFull(),
                                Textarea::make('body')->label('Mensagem')->required()->rows(8)->columnSpanFull(),
                            ]),
                        Tab::make('Analytics')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        DateTimePicker::make('scheduled_at')->label('Agendada')->native(false),
                                        DateTimePicker::make('sent_at')->label('Enviada')->native(false),
                                        DateTimePicker::make('delivered_at')->label('Entregue')->native(false),
                                        DateTimePicker::make('opened_at')->label('Aberta')->native(false),
                                        DateTimePicker::make('clicked_at')->label('Clique')->native(false),
                                        TextInput::make('external_id')->label('ID externo')->maxLength(255),
                                    ]),
                                Textarea::make('error_message')->label('Erro')->rows(3)->columnSpanFull(),
                                KeyValue::make('payload')->label('Payload')->columnSpanFull(),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
