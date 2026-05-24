<?php

namespace App\Filament\Resources\FoodDonations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class FoodDonationsTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('donated_on')->label('Data')->date('d/m/Y')->sortable(),
            TextColumn::make('donorMember.full_name')->label('Membro')->searchable()->placeholder('-'),
            TextColumn::make('donor_name')->label('Doador externo')->searchable()->placeholder('-'),
            TextColumn::make('items_count')->label('Itens')->counts('items')->sortable(),
            TextColumn::make('status')->label('Status')->badge()->sortable(),
        ])->filters([
            SelectFilter::make('status')->label('Status')->options([
                'received' => 'Recebida',
                'checked' => 'Conferida',
                'stored' => 'Armazenada',
                'discarded' => 'Descartada',
            ]),
        ])->recordActions([
            EditAction::make(),
        ])->toolbarActions([
            BulkActionGroup::make([DeleteBulkAction::make()]),
        ])->defaultSort('donated_on', 'desc');
    }
}
