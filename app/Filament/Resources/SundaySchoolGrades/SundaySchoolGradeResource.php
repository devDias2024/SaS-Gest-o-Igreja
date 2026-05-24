<?php

namespace App\Filament\Resources\SundaySchoolGrades;

use App\Filament\Resources\SecuredResource as Resource;
use App\Filament\Resources\SundaySchoolGrades\Pages\CreateSundaySchoolGrade;
use App\Filament\Resources\SundaySchoolGrades\Pages\EditSundaySchoolGrade;
use App\Filament\Resources\SundaySchoolGrades\Pages\ListSundaySchoolGrades;
use App\Filament\Resources\SundaySchoolGrades\Schemas\SundaySchoolGradeForm;
use App\Filament\Resources\SundaySchoolGrades\Tables\SundaySchoolGradesTable;
use App\Models\SundaySchoolGrade;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SundaySchoolGradeResource extends Resource
{
    protected static ?string $model = SundaySchoolGrade::class;

    protected static string|UnitEnum|null $navigationGroup = 'Escola Dominical';

    protected static ?string $navigationLabel = 'Notas e licoes';

    protected static ?string $modelLabel = 'Nota';

    protected static ?string $pluralModelLabel = 'Notas';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return SundaySchoolGradeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SundaySchoolGradesTable::configure($table);
    }

    public static function getPages(): array
    {
        return ['index' => ListSundaySchoolGrades::route('/'), 'create' => CreateSundaySchoolGrade::route('/create'), 'edit' => EditSundaySchoolGrade::route('/{record}/edit')];
    }
}
