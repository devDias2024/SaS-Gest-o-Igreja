<?php

namespace App\Filament\Resources\ChurchEvents\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ChurchEventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Evento')
                    ->tabs([
                        Tab::make('Dados gerais')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Titulo')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpan(['md' => 2]),
                                        Select::make('type')
                                            ->label('Tipo')
                                            ->default('service')
                                            ->required()
                                            ->options([
                                                'service' => 'Culto',
                                                'event' => 'Evento',
                                                'class' => 'Aula/curso',
                                                'meeting' => 'Reuniao',
                                                'rehearsal' => 'Ensaio',
                                            ]),
                                        DateTimePicker::make('starts_at')
                                            ->label('Inicio')
                                            ->default(now())
                                            ->required()
                                            ->native(false),
                                        DateTimePicker::make('ends_at')
                                            ->label('Fim')
                                            ->native(false),
                                        Select::make('event_location_id')
                                            ->label('Local')
                                            ->relationship('location', 'name')
                                            ->searchable()
                                            ->preload(),
                                        TextInput::make('capacity')
                                            ->label('Capacidade especifica')
                                            ->numeric(),
                                        Select::make('status')
                                            ->label('Status')
                                            ->default('scheduled')
                                            ->required()
                                            ->options([
                                                'scheduled' => 'Agendado',
                                                'open' => 'Inscricoes abertas',
                                                'finished' => 'Finalizado',
                                                'canceled' => 'Cancelado',
                                            ]),
                                        Textarea::make('description')
                                            ->label('Descricao')
                                            ->rows(4)
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Recorrencia')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        Select::make('recurrence_type')
                                            ->label('Repeticao')
                                            ->default('none')
                                            ->required()
                                            ->options([
                                                'none' => 'Evento unico',
                                                'daily' => 'Diario',
                                                'weekly' => 'Semanal',
                                                'monthly' => 'Mensal',
                                            ]),
                                        TextInput::make('recurrence_interval')
                                            ->label('Intervalo')
                                            ->numeric()
                                            ->default(1)
                                            ->required(),
                                        DatePicker::make('recurrence_ends_on')
                                            ->label('Repetir ate')
                                            ->native(false),
                                        CheckboxList::make('recurrence_weekdays')
                                            ->label('Dias da semana')
                                            ->options([
                                                '0' => 'Domingo',
                                                '1' => 'Segunda',
                                                '2' => 'Terca',
                                                '3' => 'Quarta',
                                                '4' => 'Quinta',
                                                '5' => 'Sexta',
                                                '6' => 'Sabado',
                                            ])
                                            ->columns(4)
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Inscricoes e capacidade')
                            ->schema([
                                Fieldset::make('Inscricoes')
                                    ->schema([
                                        Toggle::make('requires_registration')
                                            ->label('Exige inscricao')
                                            ->default(false),
                                        Toggle::make('registration_confirmation_required')
                                            ->label('Exige confirmacao')
                                            ->default(false),
                                        DateTimePicker::make('registration_starts_at')
                                            ->label('Inicio das inscricoes')
                                            ->native(false),
                                        DateTimePicker::make('registration_ends_at')
                                            ->label('Fim das inscricoes')
                                            ->native(false),
                                    ])
                                    ->columns(['default' => 1, 'md' => 2]),
                            ]),

                        Tab::make('Check-in')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        TextInput::make('check_in_token')
                                            ->label('Token do QR Code')
                                            ->disabled()
                                            ->dehydrated(false),
                                        Toggle::make('uses_dynamic_qr_code')
                                            ->label('QR Code dinamico')
                                            ->default(true),
                                        Toggle::make('allows_member_app_check_in')
                                            ->label('Check-in pelo app do membro')
                                            ->default(true),
                                        Toggle::make('allows_offline_check_in')
                                            ->label('Permitir modo offline')
                                            ->default(true),
                                        Toggle::make('geofencing_enabled')
                                            ->label('Usar geofencing')
                                            ->default(false),
                                    ]),
                            ]),

                        Tab::make('Lembretes')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        TextInput::make('reminder_hours_before')
                                            ->label('Enviar lembrete quantas horas antes')
                                            ->helperText('Os envios automaticos usam os provedores ativos em Comunicacao > Provedores.')
                                            ->numeric(),
                                        CheckboxList::make('reminder_channels')
                                            ->label('Canais')
                                            ->options([
                                                'email' => 'E-mail',
                                                'sms' => 'SMS',
                                                'whatsapp' => 'WhatsApp',
                                            ])
                                            ->helperText('O participante precisa ter e-mail ou telefone preenchido para receber o lembrete.')
                                            ->columns(3),
                                    ]),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
