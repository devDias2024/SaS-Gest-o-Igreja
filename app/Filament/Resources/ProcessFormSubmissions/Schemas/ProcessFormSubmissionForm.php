<?php

namespace App\Filament\Resources\ProcessFormSubmissions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ProcessFormSubmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Resposta')->tabs([
                Tab::make('Dados')->schema([
                    Section::make('Identificacao')->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            Select::make('process_form_id')->label('Formulario')->relationship('form', 'title')->disabled(),
                            Select::make('status')->label('Status')->required()->options([
                                'pending' => 'Pendente',
                                'approved' => 'Aprovado',
                                'completed' => 'Concluido',
                                'archived' => 'Arquivado',
                            ]),
                            TextInput::make('submitter_name')->label('Nome')->maxLength(255),
                            TextInput::make('submitter_email')->label('E-mail')->email()->maxLength(255),
                            TextInput::make('submitter_phone')->label('Telefone')->maxLength(255),
                            DateTimePicker::make('submitted_at')->label('Enviado em')->native(false),
                            Select::make('member_id')->label('Membro vinculado')->relationship('member', 'full_name')->searchable()->preload(),
                            Select::make('visitor_registration_id')->label('Visitante criado')->relationship('visitorRegistration', 'name')->searchable()->preload(),
                        ]),
                    ]),
                ]),
                Tab::make('Respostas')->schema([
                    Section::make('Campos respondidos')->schema([
                        KeyValue::make('answers')->label('Respostas')->columnSpanFull(),
                        KeyValue::make('files')->label('Arquivos')->columnSpanFull(),
                    ]),
                ]),
                Tab::make('Equipe')->schema([
                    Section::make('Comentarios internos')->schema([
                        Textarea::make('internal_notes')->label('Notas internas')->rows(5)->columnSpanFull(),
                        Repeater::make('comments')
                            ->relationship()
                            ->label('Discussao da equipe')
                            ->schema([
                                Select::make('user_id')->label('Usuario')->relationship('user', 'name')->searchable()->preload(),
                                Textarea::make('body')->label('Comentario')->required()->rows(3),
                            ])
                            ->columns(1)
                            ->columnSpanFull(),
                    ]),
                ]),
            ])->persistTabInQueryString()->columnSpanFull(),
        ]);
    }
}
