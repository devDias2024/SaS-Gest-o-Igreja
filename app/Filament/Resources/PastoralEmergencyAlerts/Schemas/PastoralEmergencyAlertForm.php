<?php

namespace App\Filament\Resources\PastoralEmergencyAlerts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PastoralEmergencyAlertForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Acionamento rapido')->schema([
                Grid::make(['default' => 1, 'md' => 2])->schema([
                    Select::make('pastoral_counseling_case_id')->label('Prontuario')->relationship('case', 'title')->searchable()->preload(),
                    Select::make('triggered_by_user_id')->label('Acionado por')->relationship('triggeredBy', 'name')->searchable()->preload(),
                    Select::make('status')->label('Status')->default('open')->options([
                        'open' => 'Aberta',
                        'in_progress' => 'Em atendimento',
                        'resolved' => 'Resolvida',
                        'canceled' => 'Cancelada',
                    ])->required(),
                    TextInput::make('contact_phone')->label('Telefone de contato')->maxLength(255),
                    DateTimePicker::make('triggered_at')->label('Acionada em')->native(false),
                    DateTimePicker::make('resolved_at')->label('Resolvida em')->native(false),
                    Textarea::make('message')->label('Mensagem sigilosa')->rows(5)->columnSpanFull(),
                ]),
            ])->columnSpanFull(),
        ]);
    }
}
