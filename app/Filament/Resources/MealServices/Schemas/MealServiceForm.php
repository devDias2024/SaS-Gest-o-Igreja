<?php

namespace App\Filament\Resources\MealServices\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class MealServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([Grid::make(['default' => 1, 'md' => 3])->schema([Select::make('church_event_id')->label('Evento')->relationship('event', 'title')->searchable()->preload(), DatePicker::make('served_on')->label('Data')->native(false)->default(now())->required(), Select::make('meal_type')->label('Refeicao')->default('lunch')->options(['breakfast' => 'Cafe', 'lunch' => 'Almoco', 'dinner' => 'Jantar', 'snack' => 'Lanche'])->required(), TextInput::make('member_count')->label('Membros')->numeric()->default(0), TextInput::make('community_count')->label('Comunidade')->numeric()->default(0), TextInput::make('volunteer_count')->label('Voluntarios')->numeric()->default(0), Textarea::make('notes')->label('Observacoes')->rows(4)->columnSpanFull()])->columnSpanFull()]);
    }
}
