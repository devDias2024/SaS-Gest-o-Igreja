<?php

namespace App\Filament\Resources\WebhookEndpoints\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WebhookEndpointForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Endpoint')->schema([
                TextInput::make('name')->label('Nome')->required()->maxLength(255),
                TextInput::make('url')->label('URL')->url()->required()->maxLength(255),
                TextInput::make('secret')->label('Segredo para assinatura')->password()->revealable()->maxLength(255),
                CheckboxList::make('events')->label('Eventos')->columns(2)->options([
                    'member.created' => 'member.created',
                    'tithe.received' => 'tithe.received',
                    'event.checkin' => 'event.checkin',
                    'form.submitted' => 'form.submitted',
                    'counseling.session_scheduled' => 'counseling.session_scheduled',
                ]),
                Toggle::make('is_active')->label('Ativo')->default(true),
            ])->columnSpanFull(),
        ]);
    }
}
