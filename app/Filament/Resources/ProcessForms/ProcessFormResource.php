<?php

namespace App\Filament\Resources\ProcessForms;

use App\Filament\Resources\ProcessForms\Pages\CreateProcessForm;
use App\Filament\Resources\ProcessForms\Pages\EditProcessForm;
use App\Filament\Resources\ProcessForms\Pages\ListProcessForms;
use App\Filament\Resources\ProcessForms\Schemas\ProcessFormForm;
use App\Filament\Resources\ProcessForms\Tables\ProcessFormsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\ProcessForm;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class ProcessFormResource extends Resource
{
    protected static ?string $model = ProcessForm::class;

    protected static string|UnitEnum|null $navigationGroup = 'Formularios & Registros';

    protected static ?string $navigationLabel = 'Formularios';

    protected static ?string $modelLabel = 'Formulario';

    protected static ?string $pluralModelLabel = 'Formularios';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return ProcessFormForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProcessFormsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProcessForms::route('/'),
            'create' => CreateProcessForm::route('/create'),
            'edit' => EditProcessForm::route('/{record}/edit'),
        ];
    }
}
