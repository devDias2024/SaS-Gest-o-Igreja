<?php

namespace App\Filament\Resources\DiningMenus\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DiningMenusTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([TextColumn::make('menu_date')->label('Data')->date('d/m/Y')->sortable(), TextColumn::make('meal_type')->label('Refeicao')->badge(), TextColumn::make('title')->label('Cardapio')->searchable(), TextColumn::make('items')->label('Itens')->limit(50)->toggleable()])->filters([SelectFilter::make('meal_type')->label('Refeicao')->options(['breakfast' => 'Cafe', 'lunch' => 'Almoco', 'dinner' => 'Jantar', 'snack' => 'Lanche'])])->recordActions([EditAction::make()])->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])->defaultSort('menu_date', 'desc');
    }
}
