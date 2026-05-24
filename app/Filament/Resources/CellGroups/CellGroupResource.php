<?php

namespace App\Filament\Resources\CellGroups;

use App\Filament\Resources\CellGroups\Pages\CreateCellGroup;
use App\Filament\Resources\CellGroups\Pages\EditCellGroup;
use App\Filament\Resources\CellGroups\Pages\ListCellGroups;
use App\Filament\Resources\CellGroups\Schemas\CellGroupForm;
use App\Filament\Resources\CellGroups\Tables\CellGroupsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\CellGroup;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class CellGroupResource extends Resource
{
    protected static ?string $model = CellGroup::class;

    protected static string|UnitEnum|null $navigationGroup = 'Ministerios & Celulas';

    protected static ?string $navigationLabel = 'Celulas';

    protected static ?string $modelLabel = 'Celula';

    protected static ?string $pluralModelLabel = 'Celulas';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return CellGroupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CellGroupsTable::configure($table);
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
            'index' => ListCellGroups::route('/'),
            'create' => CreateCellGroup::route('/create'),
            'edit' => EditCellGroup::route('/{record}/edit'),
        ];
    }
}
