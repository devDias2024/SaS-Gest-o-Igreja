<?php

namespace App\Filament\Resources\CellPlantings;

use App\Filament\Resources\CellPlantings\Pages\CreateCellPlanting;
use App\Filament\Resources\CellPlantings\Pages\EditCellPlanting;
use App\Filament\Resources\CellPlantings\Pages\ListCellPlantings;
use App\Filament\Resources\CellPlantings\Schemas\CellPlantingForm;
use App\Filament\Resources\CellPlantings\Tables\CellPlantingsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\CellPlanting;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class CellPlantingResource extends Resource
{
    protected static ?string $model = CellPlanting::class;

    protected static string|UnitEnum|null $navigationGroup = 'Ministerios & Celulas';

    protected static ?string $navigationLabel = 'Plantacao';

    protected static ?string $modelLabel = 'Plantacao de celula';

    protected static ?string $pluralModelLabel = 'Plantacao de celulas';

    protected static ?int $navigationSort = 8;

    public static function form(Schema $schema): Schema
    {
        return CellPlantingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CellPlantingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCellPlantings::route('/'),
            'create' => CreateCellPlanting::route('/create'),
            'edit' => EditCellPlanting::route('/{record}/edit'),
        ];
    }
}
