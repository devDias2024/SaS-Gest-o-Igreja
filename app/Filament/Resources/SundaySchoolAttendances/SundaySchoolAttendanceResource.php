<?php

namespace App\Filament\Resources\SundaySchoolAttendances;

use App\Filament\Resources\SecuredResource as Resource;
use App\Filament\Resources\SundaySchoolAttendances\Pages\CreateSundaySchoolAttendance;
use App\Filament\Resources\SundaySchoolAttendances\Pages\EditSundaySchoolAttendance;
use App\Filament\Resources\SundaySchoolAttendances\Pages\ListSundaySchoolAttendances;
use App\Filament\Resources\SundaySchoolAttendances\Schemas\SundaySchoolAttendanceForm;
use App\Filament\Resources\SundaySchoolAttendances\Tables\SundaySchoolAttendancesTable;
use App\Models\SundaySchoolAttendance;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SundaySchoolAttendanceResource extends Resource
{
    protected static ?string $model = SundaySchoolAttendance::class;

    protected static string|UnitEnum|null $navigationGroup = 'Escola Dominical';

    protected static ?string $navigationLabel = 'Frequencia';

    protected static ?string $modelLabel = 'Frequencia';

    protected static ?string $pluralModelLabel = 'Frequencias';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return SundaySchoolAttendanceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SundaySchoolAttendancesTable::configure($table);
    }

    public static function getPages(): array
    {
        return ['index' => ListSundaySchoolAttendances::route('/'), 'create' => CreateSundaySchoolAttendance::route('/create'), 'edit' => EditSundaySchoolAttendance::route('/{record}/edit')];
    }
}
