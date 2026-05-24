<?php

namespace App\Filament\Resources\ChildProfiles\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ChildProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Cadastro da crianca')->tabs([
                Tab::make('Dados')->schema([
                    Section::make('Identificacao')->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            TextInput::make('full_name')->label('Nome completo')->required()->maxLength(255),
                            DatePicker::make('birth_date')->label('Data de nascimento')->native(false),
                            Select::make('gender')->label('Genero')->options([
                                'female' => 'Feminino',
                                'male' => 'Masculino',
                                'not_informed' => 'Nao informado',
                            ]),
                            Select::make('child_age_group_id')->label('Faixa etaria / sala')->relationship('ageGroup', 'name')->searchable()->preload(),
                            Select::make('status')->label('Status')->default('active')->required()->options([
                                'active' => 'Ativo',
                                'inactive' => 'Inativo',
                            ]),
                            FileUpload::make('photo')->label('Foto')->image()->disk('public')->directory('children/photos'),
                        ]),
                    ]),
                ]),
                Tab::make('Saude e seguranca')->schema([
                    Section::make('Informacoes criticas')->schema([
                        Textarea::make('allergies')->label('Alergias')->rows(4)->columnSpanFull(),
                        Textarea::make('medical_conditions')->label('Condicoes medicas')->rows(4)->columnSpanFull(),
                        Textarea::make('notes')->label('Observacoes')->rows(4)->columnSpanFull(),
                    ]),
                ]),
                Tab::make('Responsaveis')->schema([
                    Section::make('Pais e responsaveis')->schema([
                        Repeater::make('guardians')
                            ->relationship()
                            ->label('Responsaveis')
                            ->schema([
                                TextInput::make('name')->label('Nome')->required()->maxLength(255),
                                TextInput::make('relationship')->label('Parentesco')->maxLength(255),
                                TextInput::make('phone')->label('Telefone')->maxLength(255),
                                TextInput::make('email')->label('E-mail')->email()->maxLength(255),
                                TextInput::make('document_number')->label('Documento')->maxLength(255),
                                Select::make('member_id')->label('Membro vinculado')->relationship('member', 'full_name')->searchable()->preload(),
                                FileUpload::make('photo')->label('Foto')->image()->disk('public')->directory('children/guardians'),
                                Select::make('can_pickup')->label('Pode retirar?')->default(true)->options([true => 'Sim', false => 'Nao']),
                                Select::make('is_primary')->label('Responsavel principal?')->default(false)->options([true => 'Sim', false => 'Nao']),
                                Textarea::make('notes')->label('Observacoes')->rows(2)->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                    ]),
                ]),
            ])->persistTabInQueryString()->columnSpanFull(),
        ]);
    }
}
