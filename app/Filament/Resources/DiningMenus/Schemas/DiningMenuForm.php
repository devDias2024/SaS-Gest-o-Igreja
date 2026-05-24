<?php

namespace App\Filament\Resources\DiningMenus\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class DiningMenuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([Grid::make(['default' => 1, 'md' => 2])->schema([DatePicker::make('menu_date')->label('Data')->native(false)->required(), Select::make('meal_type')->label('Refeicao')->default('lunch')->options(['breakfast' => 'Cafe', 'lunch' => 'Almoco', 'dinner' => 'Jantar', 'snack' => 'Lanche'])->required(), TextInput::make('title')->label('Titulo')->required()->maxLength(255)->columnSpanFull(), Textarea::make('items')->label('Itens do cardapio')->rows(5)->columnSpanFull(), Textarea::make('notes')->label('Observacoes')->rows(3)->columnSpanFull()])->columnSpanFull()]);
    }
}
