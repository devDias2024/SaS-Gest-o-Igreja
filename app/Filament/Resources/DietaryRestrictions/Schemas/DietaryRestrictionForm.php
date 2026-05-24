<?php

namespace App\Filament\Resources\DietaryRestrictions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DietaryRestrictionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Restricao alimentar')->schema([
                Grid::make(['default' => 1, 'md' => 2])->schema([
                    Select::make('member_id')
                        ->label('Membro')
                        ->relationship('member', 'full_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('type')
                        ->label('Tipo')
                        ->options([
                            'allergy' => 'Alergia',
                            'diabetes' => 'Diabetes',
                            'hypertension' => 'Hipertensao',
                            'intolerance' => 'Intolerancia',
                            'diet' => 'Dieta especifica',
                            'other' => 'Outro',
                        ])
                        ->required(),
                    Select::make('severity')
                        ->label('Gravidade')
                        ->default('attention')
                        ->options([
                            'attention' => 'Atencao',
                            'moderate' => 'Moderada',
                            'severe' => 'Grave',
                            'critical' => 'Critica',
                        ])
                        ->required(),
                    Toggle::make('is_active')->label('Ativa')->default(true),
                    TextInput::make('description')->label('Descricao')->required()->maxLength(255)->columnSpanFull(),
                    Textarea::make('notes')->label('Observacoes')->rows(4)->columnSpanFull(),
                ]),
            ])->columnSpanFull(),
        ]);
    }
}
