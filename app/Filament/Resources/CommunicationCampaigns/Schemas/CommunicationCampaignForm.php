<?php

namespace App\Filament\Resources\CommunicationCampaigns\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class CommunicationCampaignForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Campanha')
                    ->tabs([
                        Tab::make('Dados')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        TextInput::make('name')->label('Nome')->required()->maxLength(255)->columnSpan(['md' => 2]),
                                        Select::make('type')->label('Tipo')->default('announcement')->required()->options([
                                            'announcement' => 'Aviso em massa',
                                            'event' => 'Evento',
                                            'birthday' => 'Aniversario',
                                            'absence' => 'Ausencia',
                                            'custom' => 'Personalizada',
                                        ]),
                                        Select::make('communication_template_id')->label('Template')->relationship('template', 'name')->searchable()->preload(),
                                        Select::make('status')->label('Status')->default('draft')->required()->options([
                                            'draft' => 'Rascunho',
                                            'scheduled' => 'Agendada',
                                            'sending' => 'Enviando',
                                            'sent' => 'Enviada',
                                            'paused' => 'Pausada',
                                            'cancelled' => 'Cancelada',
                                        ]),
                                        DateTimePicker::make('scheduled_at')->label('Agendamento')->native(false),
                                        CheckboxList::make('channels')->label('Canais')->required()->columns(4)->options([
                                            'email' => 'E-mail',
                                            'sms' => 'SMS',
                                            'whatsapp' => 'WhatsApp',
                                            'push' => 'Push/App',
                                        ])->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('Conteudo')
                            ->schema([
                                TextInput::make('subject')->label('Assunto')->maxLength(255)->columnSpanFull(),
                                Textarea::make('body')->label('Mensagem')->rows(8)->columnSpanFull(),
                            ]),
                        Tab::make('Segmentacao')
                            ->schema([
                                KeyValue::make('segment_filters')->label('Filtros de segmento')->keyLabel('Filtro')->valueLabel('Valor')->columnSpanFull(),
                                TextInput::make('estimated_recipients')->label('Destinatarios estimados')->numeric()->default(0),
                            ]),
                        Tab::make('Resultados')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        TextInput::make('sent_count')->label('Enviadas')->numeric()->default(0),
                                        TextInput::make('delivered_count')->label('Entregues')->numeric()->default(0),
                                        TextInput::make('failed_count')->label('Falhas')->numeric()->default(0),
                                        TextInput::make('opened_count')->label('Aberturas')->numeric()->default(0),
                                        TextInput::make('clicked_count')->label('Cliques')->numeric()->default(0),
                                    ]),
                                Textarea::make('notes')->label('Notas')->rows(4)->columnSpanFull(),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
