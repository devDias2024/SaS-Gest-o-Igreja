<?php

namespace App\Filament\Resources\CellAttendances;

use App\Filament\Resources\CellAttendances\Pages\CreateCellAttendance;
use App\Filament\Resources\CellAttendances\Pages\EditCellAttendance;
use App\Filament\Resources\CellAttendances\Pages\ListCellAttendances;
use App\Filament\Resources\CellAttendances\Schemas\CellAttendanceForm;
use App\Filament\Resources\CellAttendances\Tables\CellAttendancesTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\CellAttendance;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class CellAttendanceResource extends Resource
{
    protected static ?string $model = CellAttendance::class;

    protected static string|UnitEnum|null $navigationGroup = 'Ministerios & Celulas';

    protected static ?string $navigationLabel = 'Frequencia';

    protected static ?string $modelLabel = 'Frequencia';

    protected static ?string $pluralModelLabel = 'Frequencias';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return CellAttendanceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CellAttendancesTable::configure($table);
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
            'index' => ListCellAttendances::route('/'),
            'create' => CreateCellAttendance::route('/create'),
            'edit' => EditCellAttendance::route('/{record}/edit'),
        ];
    }
}
