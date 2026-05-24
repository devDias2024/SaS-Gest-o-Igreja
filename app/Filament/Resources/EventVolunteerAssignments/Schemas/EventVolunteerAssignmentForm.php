<?php

namespace App\Filament\Resources\EventVolunteerAssignments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class EventVolunteerAssignmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Escala de voluntario')
                    ->tabs([
                        Tab::make('Escala')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        Select::make('church_event_id')->label('Evento')->relationship('event', 'title')->searchable()->preload()->required(),
                                        Select::make('volunteer_role_id')->label('Funcao')->relationship('role', 'name')->searchable()->preload()->required(),
                                        Select::make('member_id')->label('Membro')->relationship('member', 'full_name')->searchable()->preload(),
                                        TextInput::make('slot_number')->label('Vaga')->numeric()->default(1)->required(),
                                    ]),
                            ]),
                        Tab::make('Status')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        Select::make('status')->label('Status')->default('scheduled')->required()->options([
                                            'scheduled' => 'Escalado',
                                            'confirmed' => 'Confirmado',
                                            'declined' => 'Recusou',
                                            'replaced' => 'Substituido',
                                        ]),
                                        Toggle::make('auto_assigned')->label('Gerado por rotacao')->inline(false),
                                        DateTimePicker::make('notified_at')->label('Notificado em')->native(false),
                                        Textarea::make('notes')->label('Observacoes')->rows(3)->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
