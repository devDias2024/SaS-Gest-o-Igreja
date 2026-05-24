<?php

namespace App\Filament\Resources\VisitorRegistrations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class VisitorRegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(['default' => 1, 'md' => 2])->schema([
                TextInput::make('name')->label('Nome')->required()->maxLength(255),
                TextInput::make('email')->label('E-mail')->email()->maxLength(255),
                TextInput::make('phone')->label('Telefone')->maxLength(255),
                DatePicker::make('planned_visit_on')->label('Data da visita')->native(false),
                TextInput::make('preferred_service')->label('Culto/evento de interesse')->maxLength(255),
                TextInput::make('party_size')->label('Quantidade de pessoas')->numeric()->default(1)->required(),
                Select::make('status')->label('Status')->default('new')->required()->options([
                    'new' => 'Novo',
                    'contacted' => 'Contatado',
                    'scheduled' => 'Agendado',
                    'attended' => 'Compareceu',
                    'closed' => 'Fechado',
                ]),
                DateTimePicker::make('contacted_at')->label('Contatado em')->native(false),
                Textarea::make('notes')->label('Observacoes')->rows(5)->columnSpanFull(),
                Select::make('communication_inbox_thread_id')->label('Conversa')->relationship('inboxThread', 'subject')->searchable()->preload(),
                KeyValue::make('metadata')->label('Metadados')->columnSpanFull(),
            ]),
        ]);
    }
}
