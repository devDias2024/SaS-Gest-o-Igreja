<?php

namespace App\Filament\Resources\SundaySchoolEnrollments;

use App\Filament\Resources\SecuredResource as Resource;
use App\Filament\Resources\SundaySchoolEnrollments\Pages\CreateSundaySchoolEnrollment;
use App\Filament\Resources\SundaySchoolEnrollments\Pages\EditSundaySchoolEnrollment;
use App\Filament\Resources\SundaySchoolEnrollments\Pages\ListSundaySchoolEnrollments;
use App\Filament\Resources\SundaySchoolEnrollments\Schemas\SundaySchoolEnrollmentForm;
use App\Filament\Resources\SundaySchoolEnrollments\Tables\SundaySchoolEnrollmentsTable;
use App\Models\SundaySchoolEnrollment;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SundaySchoolEnrollmentResource extends Resource
{
    protected static ?string $model = SundaySchoolEnrollment::class;

    protected static string|UnitEnum|null $navigationGroup = 'Escola Dominical';

    protected static ?string $navigationLabel = 'Matriculas';

    protected static ?string $modelLabel = 'Matricula';

    protected static ?string $pluralModelLabel = 'Matriculas';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return SundaySchoolEnrollmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SundaySchoolEnrollmentsTable::configure($table);
    }

    public static function getPages(): array
    {
        return ['index' => ListSundaySchoolEnrollments::route('/'), 'create' => CreateSundaySchoolEnrollment::route('/create'), 'edit' => EditSundaySchoolEnrollment::route('/{record}/edit')];
    }
}
