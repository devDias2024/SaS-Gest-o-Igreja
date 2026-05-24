<?php

namespace App\Filament\Resources\PastoralCounselingSessions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PastoralCounselingSessionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Sessao')->tabs([
                Tab::make('Agenda')->schema([
                    Section::make('Agendamento')->schema([
                        Grid::make(['default' => 1, 'md' => 3])->schema([
                            Select::make('pastoral_counseling_case_id')->label('Prontuario')->relationship('case', 'title')->searchable()->preload()->required(),
                            Select::make('pastor_user_id')->label('Pastor')->relationship('pastor', 'name')->searchable()->preload(),
                            DateTimePicker::make('scheduled_at')->label('Data e hora')->native(false)->required(),
                            TextInput::make('duration_minutes')->label('Duracao')->numeric()->default(60)->suffix('min')->required(),
                            Select::make('location_type')->label('Tipo')->default('in_person')->options([
                                'in_person' => 'Presencial',
                                'online' => 'Online',
                                'phone' => 'Telefone',
                            ])->required(),
                            Select::make('status')->label('Status')->default('scheduled')->options([
                                'scheduled' => 'Agendada',
                                'completed' => 'Realizada',
                                'missed' => 'Nao compareceu',
                                'canceled' => 'Cancelada',
                            ])->required(),
                            TextInput::make('location')->label('Local')->maxLength(255),
                            TextInput::make('meeting_url')->label('Link online')->maxLength(255),
                            DateTimePicker::make('reminder_at')->label('Lembrete em')->native(false),
                        ]),
                    ]),
                ]),
                Tab::make('Sigilo')->schema([
                    Section::make('Anotacoes criptografadas')->schema([
                        Textarea::make('confidential_notes')->label('Anotacoes sigilosas')->rows(8)->columnSpanFull(),
                        Textarea::make('next_steps')->label('Proximos passos')->rows(5)->columnSpanFull(),
                    ]),
                ]),
            ])->persistTabInQueryString()->columnSpanFull(),
        ]);
    }
}
