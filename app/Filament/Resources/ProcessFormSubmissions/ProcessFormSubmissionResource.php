<?php

namespace App\Filament\Resources\ProcessFormSubmissions;

use App\Filament\Resources\ProcessFormSubmissions\Pages\EditProcessFormSubmission;
use App\Filament\Resources\ProcessFormSubmissions\Pages\ListProcessFormSubmissions;
use App\Filament\Resources\ProcessFormSubmissions\Schemas\ProcessFormSubmissionForm;
use App\Filament\Resources\ProcessFormSubmissions\Tables\ProcessFormSubmissionsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\ProcessFormSubmission;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class ProcessFormSubmissionResource extends Resource
{
    protected static ?string $model = ProcessFormSubmission::class;

    protected static string|UnitEnum|null $navigationGroup = 'Formularios & Registros';

    protected static ?string $navigationLabel = 'Respostas';

    protected static ?string $modelLabel = 'Resposta';

    protected static ?string $pluralModelLabel = 'Respostas';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return ProcessFormSubmissionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProcessFormSubmissionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProcessFormSubmissions::route('/'),
            'edit' => EditProcessFormSubmission::route('/{record}/edit'),
        ];
    }
}
