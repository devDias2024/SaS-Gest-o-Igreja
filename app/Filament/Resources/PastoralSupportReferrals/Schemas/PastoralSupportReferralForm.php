<?php

namespace App\Filament\Resources\PastoralSupportReferrals\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PastoralSupportReferralForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Encaminhamento para rede de apoio')->schema([
                Grid::make(['default' => 1, 'md' => 2])->schema([
                    Select::make('pastoral_counseling_case_id')->label('Prontuario')->relationship('case', 'title')->searchable()->preload()->required(),
                    Select::make('type')->label('Tipo')->required()->options([
                        'psychologist' => 'Psicologo',
                        'psychiatrist' => 'Psiquiatra',
                        'social_assistance' => 'Assistencia social',
                        'legal' => 'Apoio juridico',
                        'other' => 'Outro',
                    ]),
                    TextInput::make('provider_name')->label('Profissional/instituicao')->required()->maxLength(255),
                    TextInput::make('contact')->label('Contato')->maxLength(255),
                    Select::make('status')->label('Status')->default('suggested')->options([
                        'suggested' => 'Sugerido',
                        'accepted' => 'Aceito',
                        'scheduled' => 'Agendado',
                        'declined' => 'Recusado',
                        'completed' => 'Concluido',
                    ]),
                    DateTimePicker::make('referred_at')->label('Encaminhado em')->native(false),
                    Textarea::make('notes')->label('Notas sigilosas')->rows(5)->columnSpanFull(),
                ]),
            ])->columnSpanFull(),
        ]);
    }
}
