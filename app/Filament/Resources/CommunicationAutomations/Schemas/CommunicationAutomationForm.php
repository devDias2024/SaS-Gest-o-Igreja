<?php

namespace App\Filament\Resources\CommunicationAutomations\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class CommunicationAutomationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Automacao')
                    ->tabs([
                        Tab::make('Gatilho')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        TextInput::make('name')->label('Nome')->required()->maxLength(255)->columnSpan(['md' => 2]),
                                        Select::make('status')->label('Status')->default('active')->required()->options([
                                            'active' => 'Ativa',
                                            'paused' => 'Pausada',
                                            'archived' => 'Arquivada',
                                        ]),
                                        Select::make('trigger')->label('Gatilho')->required()->options([
                                            'member_created' => 'Novo membro',
                                            'birthday' => 'Aniversario',
                                            'absence_3_weeks' => 'Faltou 3 semanas',
                                            'event_registered' => 'Inscricao em evento',
                                            'pledge_late' => 'Promessa em atraso',
                                            'custom' => 'Personalizado',
                                        ]),
                                        Select::make('communication_template_id')->label('Template')->relationship('template', 'name')->searchable()->preload(),
                                        TextInput::make('delay_minutes')->label('Atraso em minutos')->numeric()->default(0),
                                    ]),
                                CheckboxList::make('channels')->label('Canais')->required()->columns(4)->options([
                                    'email' => 'E-mail',
                                    'sms' => 'SMS',
                                    'whatsapp' => 'WhatsApp',
                                    'push' => 'Push/App',
                                ])->columnSpanFull(),
                            ]),
                        Tab::make('Condicoes')
                            ->schema([
                                KeyValue::make('conditions')->label('Condicoes')->keyLabel('Campo')->valueLabel('Valor')->columnSpanFull(),
                            ]),
                        Tab::make('Execucao')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        TextInput::make('run_count')->label('Execucoes')->numeric()->default(0),
                                        TextInput::make('last_run_at')->label('Ultima execucao')->disabled()->dehydrated(false),
                                    ]),
                                Textarea::make('notes')->label('Notas')->rows(5)->columnSpanFull(),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
