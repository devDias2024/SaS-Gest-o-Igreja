<?php

namespace App\Filament\Resources\PublicContacts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class PublicContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(['default' => 1, 'md' => 2])->schema([
                TextInput::make('name')->label('Nome')->required()->maxLength(255),
                TextInput::make('email')->label('E-mail')->email()->maxLength(255),
                TextInput::make('phone')->label('Telefone')->maxLength(255),
                TextInput::make('subject')->label('Assunto')->maxLength(255),
                Select::make('status')->label('Status')->default('new')->required()->options([
                    'new' => 'Novo',
                    'in_progress' => 'Em atendimento',
                    'responded' => 'Respondido',
                    'closed' => 'Fechado',
                ]),
                DateTimePicker::make('responded_at')->label('Respondido em')->native(false),
                Textarea::make('message')->label('Mensagem')->required()->rows(7)->columnSpanFull(),
                Select::make('communication_inbox_thread_id')->label('Conversa')->relationship('inboxThread', 'subject')->searchable()->preload(),
                KeyValue::make('metadata')->label('Metadados')->columnSpanFull(),
            ]),
        ]);
    }
}
