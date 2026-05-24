<?php

namespace App\Filament\Resources\ChildAgeGroups\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ChildAgeGroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Faixa etaria')->tabs([
                Tab::make('Dados')->schema([
                    Section::make('Sala')->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            TextInput::make('name')->label('Nome')->required()->maxLength(255),
                            TextInput::make('location')->label('Sala/local')->maxLength(255),
                            TextInput::make('capacity')->label('Capacidade')->numeric(),
                            Toggle::make('is_active')->label('Ativa')->default(true),
                        ]),
                    ]),
                ]),
                Tab::make('Idade')->schema([
                    Section::make('Faixa em meses')->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            TextInput::make('min_age_months')->label('Idade minima em meses')->numeric()->default(0)->required(),
                            TextInput::make('max_age_months')->label('Idade maxima em meses')->numeric(),
                        ]),
                    ]),
                ]),
                Tab::make('Observacoes')->schema([
                    Section::make('Notas internas')->schema([
                        Textarea::make('notes')->label('Observacoes')->rows(5)->columnSpanFull(),
                    ]),
                ]),
            ])->persistTabInQueryString()->columnSpanFull(),
        ]);
    }
}
