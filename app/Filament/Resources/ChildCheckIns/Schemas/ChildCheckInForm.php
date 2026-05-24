<?php

namespace App\Filament\Resources\ChildCheckIns\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ChildCheckInForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Check-in infantil')->tabs([
                Tab::make('Entrada')->schema([
                    Section::make('Dados da entrada')->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            Select::make('child_profile_id')->label('Crianca')->relationship('child', 'full_name')->searchable()->preload()->required(),
                            Select::make('child_age_group_id')->label('Faixa etaria / sala')->relationship('ageGroup', 'name')->searchable()->preload(),
                            Select::make('checked_in_by_guardian_id')->label('Quem deixou')->relationship('checkedInBy', 'name')->searchable()->preload(),
                            DateTimePicker::make('checked_in_at')->label('Entrada')->native(false),
                            Select::make('status')->label('Status')->default('checked_in')->required()->options([
                                'checked_in' => 'Na sala',
                                'checked_out' => 'Retirada',
                                'cancelled' => 'Cancelado',
                            ]),
                        ]),
                    ]),
                ]),
                Tab::make('Etiqueta')->schema([
                    Section::make('Codigos de seguranca')->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            TextInput::make('check_in_code')->label('Codigo da etiqueta')->maxLength(255),
                            TextInput::make('pickup_code')->label('Codigo de retirada')->maxLength(255),
                            DateTimePicker::make('label_printed_at')->label('Etiqueta impressa em')->native(false),
                        ]),
                    ]),
                ]),
                Tab::make('Retirada')->schema([
                    Section::make('Validacao da retirada')->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            Select::make('checked_out_by_guardian_id')->label('Quem retirou')->relationship('checkedOutBy', 'name')->searchable()->preload(),
                            Select::make('pickup_authorization_id')->label('Autorizacao de terceiro')->relationship('pickupAuthorization', 'authorized_name')->searchable()->preload(),
                            DateTimePicker::make('checked_out_at')->label('Retirada')->native(false),
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
