<?php

namespace App\Filament\Resources\PastoralCounselingCases\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PastoralCounselingCaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Prontuario sigiloso')->tabs([
                Tab::make('Identificacao')->schema([
                    Section::make('Acesso restrito')->description('Somente o pastor responsavel e usuarios autorizados conseguem ver este prontuario.')->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            TextInput::make('title')->label('Titulo interno')->required()->maxLength(255)->columnSpanFull(),
                            Select::make('member_id')->label('Aconselhado')->relationship('member', 'full_name')->searchable()->preload(),
                            Select::make('primary_pastor_user_id')->label('Pastor responsavel')->relationship('primaryPastor', 'name')->searchable()->preload()->required(),
                            Select::make('authorizedUsers')->label('Outros usuarios autorizados')->relationship('authorizedUsers', 'name')->multiple()->searchable()->preload()->columnSpanFull(),
                            Select::make('privacy_level')->label('Nivel de sigilo')->default('confidential')->options([
                                'confidential' => 'Sigiloso',
                                'restricted' => 'Restrito',
                                'critical' => 'Critico',
                            ])->required(),
                        ]),
                    ]),
                    Section::make('Status')->schema([
                        Grid::make(['default' => 1, 'md' => 3])->schema([
                            Select::make('status')->label('Status')->default('open')->options([
                                'open' => 'Aberto',
                                'in_follow_up' => 'Em acompanhamento',
                                'referred' => 'Encaminhado',
                                'closed' => 'Encerrado',
                            ])->required(),
                            TextInput::make('main_subject')->label('Assunto principal')->maxLength(255),
                            DateTimePicker::make('opened_at')->label('Aberto em')->native(false),
                            DateTimePicker::make('closed_at')->label('Encerrado em')->native(false),
                        ]),
                    ]),
                ]),
                Tab::make('LGPD e risco')->schema([
                    Section::make('Consentimento especifico')->schema([
                        DateTimePicker::make('lgpd_consented_at')->label('Consentimento registrado em')->native(false),
                        Textarea::make('lgpd_consent_text')->label('Texto/observacao do consentimento')->rows(5)->columnSpanFull(),
                    ]),
                    Section::make('Contato emergencial')->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            TextInput::make('emergency_contact_name')->label('Nome do contato')->maxLength(255),
                            TextInput::make('emergency_contact_phone')->label('Telefone do contato')->maxLength(255),
                            Textarea::make('risk_notes')->label('Notas de risco')->rows(5)->columnSpanFull(),
                        ]),
                    ]),
                ]),
            ])->persistTabInQueryString()->columnSpanFull(),
        ]);
    }
}
