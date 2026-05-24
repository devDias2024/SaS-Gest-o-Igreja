<?php

namespace App\Filament\Resources\CellMeetings\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class CellMeetingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Reuniao de celula')
                    ->tabs([
                        Tab::make('Agenda')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        Select::make('cell_group_id')->label('Celula')->relationship('cellGroup', 'name')->searchable()->preload()->required(),
                                        Select::make('host_member_id')->label('Anfitriao')->relationship('hostMember', 'full_name')->searchable()->preload(),
                                        Select::make('type')->label('Tipo')->default('meeting')->required()->options([
                                            'meeting' => 'Reuniao',
                                            'visit' => 'Visita',
                                            'training' => 'Treinamento',
                                            'outreach' => 'Evangelismo',
                                        ]),
                                        DateTimePicker::make('starts_at')->label('Inicio')->default(now())->required()->native(false),
                                        DateTimePicker::make('ends_at')->label('Fim')->native(false),
                                        Select::make('status')->label('Status')->default('scheduled')->required()->options([
                                            'scheduled' => 'Agendada',
                                            'completed' => 'Realizada',
                                            'canceled' => 'Cancelada',
                                        ]),
                                    ]),
                            ]),
                        Tab::make('Relatorio')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        TextInput::make('theme')->label('Tema')->maxLength(255),
                                        TextInput::make('visitors_count')->label('Visitantes')->numeric()->default(0),
                                        TextInput::make('offerings_cents')->label('Ofertas em centavos')->numeric()->default(0),
                                        Textarea::make('notes')->label('Observacoes')->rows(5)->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
