<?php

namespace App\Filament\Resources\Assets\Tables;

use App\Filament\Exports\AssetExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AssetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->label('Codigo')->searchable()->sortable()->copyable(),
                TextColumn::make('name')->label('Item')->searchable()->sortable(),
                TextColumn::make('category.name')->label('Categoria')->badge()->toggleable(),
                TextColumn::make('location.name')->label('Local')->searchable()->toggleable(),
                TextColumn::make('asset_type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'asset' => 'Patrimonio',
                        'stock' => 'Estoque',
                        'both' => 'Ambos',
                        default => 'Outro',
                    }),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'available' => 'Disponivel',
                        'loaned' => 'Emprestado',
                        'maintenance' => 'Manutencao',
                        'inactive' => 'Inativo',
                        'discarded' => 'Baixado',
                        default => 'Outro',
                    }),
                TextColumn::make('quantity_on_hand')->label('Saldo')->numeric()->sortable(),
                TextColumn::make('purchase_value')->label('Valor compra')->money('BRL')->sortable()->toggleable(),
                TextColumn::make('current_value')->label('Valor atual')->money('BRL')->sortable()->toggleable(),
                TextColumn::make('warranty_expires_at')->label('Garantia')->date('d/m/Y')->sortable()->toggleable(),
                TextColumn::make('next_maintenance_at')->label('Manutencao')->date('d/m/Y')->sortable()->toggleable(),
            ])
            ->filters([
                SelectFilter::make('asset_type')->label('Tipo')->options([
                    'asset' => 'Patrimonio',
                    'stock' => 'Estoque',
                    'both' => 'Ambos',
                ]),
                SelectFilter::make('status')->label('Status')->options([
                    'available' => 'Disponivel',
                    'loaned' => 'Emprestado',
                    'maintenance' => 'Em manutencao',
                    'inactive' => 'Inativo',
                    'discarded' => 'Baixado',
                ]),
                SelectFilter::make('asset_category_id')->label('Categoria')->relationship('category', 'name')->searchable()->preload(),
                SelectFilter::make('asset_location_id')->label('Local')->relationship('location', 'name')->searchable()->preload(),
                Filter::make('low_stock')
                    ->label('Estoque baixo')
                    ->query(fn (Builder $query): Builder => $query->whereColumn('quantity_on_hand', '<=', 'minimum_quantity')),
                Filter::make('warranty_expiring')
                    ->label('Garantia vencendo')
                    ->query(fn (Builder $query): Builder => $query->whereBetween('warranty_expires_at', [now(), now()->addDays(30)])),
                Filter::make('maintenance_due')
                    ->label('Manutencao vencendo')
                    ->query(fn (Builder $query): Builder => $query->whereDate('next_maintenance_at', '<=', now()->addDays(30))),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()
                        ->exporter(AssetExporter::class),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
