<?php

namespace App\Filament\Resources\PastoralVisits\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PastoralVisitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Visita pastoral')
                    ->tabs([
                        Tab::make('Agenda')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        Select::make('member_id')->label('Membro')->relationship('member', 'full_name')->searchable()->preload(),
                                        Select::make('cell_group_id')->label('Celula')->relationship('cellGroup', 'name')->searchable()->preload(),
                                        Select::make('pastor_id')->label('Pastor/lider')->relationship('pastor', 'full_name')->searchable()->preload(),
                                        DateTimePicker::make('scheduled_at')->label('Agendada para')->native(false),
                                        DateTimePicker::make('visited_at')->label('Realizada em')->native(false),
                                        Select::make('visit_type')->label('Tipo')->default('pastoral')->required()->options([
                                            'pastoral' => 'Pastoral',
                                            'new_member' => 'Novo membro',
                                            'care' => 'Cuidado',
                                            'discipleship' => 'Discipulado',
                                        ]),
                                        Select::make('status')->label('Status')->default('scheduled')->required()->options([
                                            'scheduled' => 'Agendada',
                                            'completed' => 'Realizada',
                                            'canceled' => 'Cancelada',
                                        ]),
                                        TextInput::make('address')->label('Endereco')->maxLength(255)->columnSpan(['md' => 2]),
                                    ]),
                            ]),
                        Tab::make('Ficha')
                            ->schema([
                                Textarea::make('reason')->label('Motivo')->rows(4)->columnSpanFull(),
                                Textarea::make('summary')->label('Resumo')->rows(5)->columnSpanFull(),
                                Textarea::make('next_steps')->label('Proximos passos')->rows(4)->columnSpanFull(),
                            ]),
                        Tab::make('Acompanhamento')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        Toggle::make('requires_follow_up')->label('Requer acompanhamento')->default(false),
                                        DatePicker::make('follow_up_on')->label('Retorno em')->native(false),
                                    ]),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
