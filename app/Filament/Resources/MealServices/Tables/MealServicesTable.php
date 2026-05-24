<?php

namespace App\Filament\Resources\MealServices\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MealServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([TextColumn::make('served_on')->label('Data')->date('d/m/Y')->sortable(), TextColumn::make('event.title')->label('Evento')->searchable()->placeholder('Dia comum'), TextColumn::make('meal_type')->label('Refeicao')->badge(), TextColumn::make('member_count')->label('Membros')->sortable(), TextColumn::make('community_count')->label('Comunidade')->sortable(), TextColumn::make('volunteer_count')->label('Voluntarios')->sortable(), TextColumn::make('total_served')->label('Total')])->filters([SelectFilter::make('meal_type')->label('Refeicao')->options(['breakfast' => 'Cafe', 'lunch' => 'Almoco', 'dinner' => 'Jantar', 'snack' => 'Lanche'])])->recordActions([EditAction::make()])->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])->defaultSort('served_on', 'desc');
    }
}
