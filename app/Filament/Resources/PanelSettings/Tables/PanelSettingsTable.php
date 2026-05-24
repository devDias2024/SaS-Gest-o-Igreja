<?php

namespace App\Filament\Resources\PanelSettings\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PanelSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('panel_name')->label('Painel'),
                TextColumn::make('font_family')->label('Fonte'),
                TextColumn::make('visual_style')->label('Estilo')->badge(),
                ColorColumn::make('primary_color')->label('Cor'),
                IconColumn::make('allow_dark_mode')->label('Modo escuro')->boolean(),
            ])
            ->recordActions([
                EditAction::make()->label('Configurar'),
            ]);
    }
}
