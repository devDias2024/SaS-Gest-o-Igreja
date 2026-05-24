<?php

namespace App\Filament\Resources\ChildCheckIns\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ChildCheckInsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('checked_in_at')->label('Entrada')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('child.full_name')->label('Crianca')->searchable()->sortable(),
                TextColumn::make('ageGroup.name')->label('Sala')->badge(),
                TextColumn::make('checkedInBy.name')->label('Deixou')->searchable(),
                TextColumn::make('checkedOutBy.name')->label('Retirou')->searchable(),
                TextColumn::make('pickup_code')->label('Codigo retirada')->copyable()->badge(),
                TextColumn::make('status')->label('Status')->badge()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'checked_in' => 'Na sala',
                    'checked_out' => 'Retirada',
                    'cancelled' => 'Cancelado',
                ]),
                SelectFilter::make('child_age_group_id')->label('Sala')->relationship('ageGroup', 'name')->searchable()->preload(),
                SelectFilter::make('child_profile_id')->label('Crianca')->relationship('child', 'full_name')->searchable()->preload(),
                Filter::make('period')
                    ->label('Periodo')
                    ->schema([
                        DatePicker::make('from')->label('De')->native(false),
                        DatePicker::make('until')->label('Ate')->native(false),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['from'] ?? null, fn (Builder $query, string $date): Builder => $query->whereDate('checked_in_at', '>=', $date))
                        ->when($data['until'] ?? null, fn (Builder $query, string $date): Builder => $query->whereDate('checked_in_at', '<=', $date))),
                Filter::make('today')
                    ->label('Hoje')
                    ->query(fn (Builder $query): Builder => $query->whereDate('checked_in_at', today())),
            ])
            ->recordActions([
                Action::make('printLabel')
                    ->label('Etiqueta')
                    ->icon('heroicon-o-printer')
                    ->url(fn ($record): string => route('children.check-in.label', $record))
                    ->openUrlInNewTab(),
                Action::make('checkout')
                    ->label('Retirar')
                    ->icon('heroicon-o-shield-check')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update([
                        'status' => 'checked_out',
                        'checked_out_at' => now(),
                    ])),
                EditAction::make(),
            ])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
