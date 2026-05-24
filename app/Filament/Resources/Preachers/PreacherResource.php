<?php

namespace App\Filament\Resources\Preachers;

use App\Filament\Resources\Preachers\Pages\CreatePreacher;
use App\Filament\Resources\Preachers\Pages\EditPreacher;
use App\Filament\Resources\Preachers\Pages\ListPreachers;
use App\Filament\Resources\Preachers\Schemas\PreacherForm;
use App\Filament\Resources\Preachers\Tables\PreachersTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\Preacher;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class PreacherResource extends Resource
{
    protected static ?string $model = Preacher::class;

    protected static string|UnitEnum|null $navigationGroup = 'Biblioteca de Cultos';

    protected static ?string $navigationLabel = 'Pregadores';

    protected static ?string $modelLabel = 'Pregador';

    protected static ?string $pluralModelLabel = 'Pregadores';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return PreacherForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PreachersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPreachers::route('/'),
            'create' => CreatePreacher::route('/create'),
            'edit' => EditPreacher::route('/{record}/edit'),
        ];
    }
}
