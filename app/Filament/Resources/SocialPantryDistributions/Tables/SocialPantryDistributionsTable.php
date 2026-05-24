<?php

namespace App\Filament\Resources\SocialPantryDistributions\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SocialPantryDistributionsTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('distributed_on')->label('Data')->date('d/m/Y')->sortable(),
            TextColumn::make('member.full_name')->label('Membro')->searchable()->placeholder('-'),
            TextColumn::make('beneficiary_name')->label('Beneficiario')->searchable()->placeholder('-'),
            TextColumn::make('audience_type')->label('Publico')->badge()->sortable(),
            TextColumn::make('family_size')->label('Pessoas')->sortable(),
            TextColumn::make('items_count')->label('Itens')->counts('items')->sortable(),
            TextColumn::make('status')->label('Status')->badge()->sortable(),
        ])->filters([
            SelectFilter::make('audience_type')->label('Publico')->options([
                'member' => 'Membro',
                'community' => 'Comunidade',
            ]),
            SelectFilter::make('status')->label('Status')->options([
                'scheduled' => 'Agendada',
                'delivered' => 'Entregue',
                'cancelled' => 'Cancelada',
            ]),
        ])->recordActions([
            EditAction::make(),
        ])->headerActions([
            Action::make('audience_report')
                ->label('Relatorio publico atendido')
                ->url(route('social-pantry.reports.audience'))
                ->openUrlInNewTab(),
        ])->toolbarActions([
            BulkActionGroup::make([DeleteBulkAction::make()]),
        ])->defaultSort('distributed_on', 'desc');
    }
}
