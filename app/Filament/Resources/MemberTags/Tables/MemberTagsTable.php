<?php

namespace App\Filament\Resources\MemberTags\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MemberTagsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('color')
                    ->label('Cor')
                    ->badge()
                    ->color(fn (?string $state): string => match (strtolower($state ?? '')) {
                        'danger', 'red' => 'danger',
                        'info', 'blue' => 'info',
                        'success', 'green' => 'success',
                        'emerald' => 'emerald',
                        'warning', 'yellow', 'amber' => 'warning',
                        'primary', 'purple', 'indigo' => 'primary',
                        'secondary' => 'secondary',
                        'cyan' => 'cyan',
                        'violet' => 'violet',
                        'rose', 'pink' => 'rose',
                        'teal' => 'teal',
                        'gray', 'slate', 'zinc', 'stone' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (?string $state): string => match (strtolower($state ?? '')) {
                        'danger', 'red' => 'Vermelho',
                        'info', 'blue' => 'Azul',
                        'success', 'green' => 'Verde',
                        'emerald' => 'Esmeralda',
                        'warning', 'yellow', 'amber' => 'Amarelo',
                        'primary', 'purple', 'indigo' => 'Destaque',
                        'secondary' => 'Secundária',
                        'cyan' => 'Ciano',
                        'violet' => 'Violeta',
                        'rose', 'pink' => 'Rosa',
                        'teal' => 'Turquesa',
                        'gray', 'slate', 'zinc', 'stone' => 'Cinza',
                        default => ucfirst(strtolower($state ?? '')),
                    }),
                TextColumn::make('members_count')
                    ->label('Membros')
                    ->counts('members')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
