<?php

namespace App\Filament\Resources\EventRegistrations\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;

class EventRegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Inscricao')
                    ->tabs([
                        Tab::make('Participante')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        Select::make('church_event_id')
                                            ->label('Evento')
                                            ->relationship('event', 'title')
                                            ->searchable()
                                            ->preload()
                                            ->required(),
                                        Select::make('member_id')
                                            ->label('Membro')
                                            ->relationship('member', 'full_name')
                                            ->searchable()
                                            ->preload(),
                                        TextInput::make('guest_name')->label('Convidado')->maxLength(255),
                                        TextInput::make('guest_email')->label('E-mail')->email()->maxLength(255),
                                        PhoneNumber::make('guest_phone')->label('Telefone')->maxLength(255),
                                        TextInput::make('quantity')->label('Quantidade')->numeric()->default(1)->required(),
                                    ]),
                            ]),
                        Tab::make('Status')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        Select::make('status')
                                            ->label('Status')
                                            ->default('pending')
                                            ->required()
                                            ->options([
                                                'pending' => 'Pendente',
                                                'confirmed' => 'Confirmada',
                                                'checked_in' => 'Presente',
                                                'canceled' => 'Cancelada',
                                                'waiting_list' => 'Lista de espera',
                                            ]),
                                        DateTimePicker::make('confirmed_at')->label('Confirmada em')->native(false),
                                        DateTimePicker::make('reminder_sent_at')->label('Lembrete enviado em')->native(false),
                                        Textarea::make('notes')->label('Observacoes')->rows(3)->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
