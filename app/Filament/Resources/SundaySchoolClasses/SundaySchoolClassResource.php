<?php

namespace App\Filament\Resources\SundaySchoolClasses;

use App\Filament\Resources\SecuredResource as Resource;
use App\Filament\Resources\SundaySchoolClasses\Pages\CreateSundaySchoolClass;
use App\Filament\Resources\SundaySchoolClasses\Pages\EditSundaySchoolClass;
use App\Filament\Resources\SundaySchoolClasses\Pages\ListSundaySchoolClasses;
use App\Filament\Resources\SundaySchoolClasses\Schemas\SundaySchoolClassForm;
use App\Filament\Resources\SundaySchoolClasses\Tables\SundaySchoolClassesTable;
use App\Models\SundaySchoolClass;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SundaySchoolClassResource extends Resource
{
    protected static ?string $model = SundaySchoolClass::class;

    protected static string|UnitEnum|null $navigationGroup = 'Escola Dominical';

    protected static ?string $navigationLabel = 'Classes e cursos';

    protected static ?string $modelLabel = 'Classe';

    protected static ?string $pluralModelLabel = 'Classes';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return SundaySchoolClassForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SundaySchoolClassesTable::configure($table);
    }

    public static function getPages(): array
    {
        return ['index' => ListSundaySchoolClasses::route('/'), 'create' => CreateSundaySchoolClass::route('/create'), 'edit' => EditSundaySchoolClass::route('/{record}/edit')];
    }
}
