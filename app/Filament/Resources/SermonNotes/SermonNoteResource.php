<?php

namespace App\Filament\Resources\SermonNotes;

use App\Filament\Resources\SecuredResource as Resource;
use App\Filament\Resources\SermonNotes\Pages\CreateSermonNote;
use App\Filament\Resources\SermonNotes\Pages\EditSermonNote;
use App\Filament\Resources\SermonNotes\Pages\ListSermonNotes;
use App\Filament\Resources\SermonNotes\Schemas\SermonNoteForm;
use App\Filament\Resources\SermonNotes\Tables\SermonNotesTable;
use App\Models\SermonNote;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SermonNoteResource extends Resource
{
    protected static ?string $model = SermonNote::class;

    protected static string|UnitEnum|null $navigationGroup = 'Biblioteca de Cultos';

    protected static ?string $navigationLabel = 'Anotacoes';

    protected static ?string $modelLabel = 'Anotacao';

    protected static ?string $pluralModelLabel = 'Anotacoes';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return SermonNoteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SermonNotesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSermonNotes::route('/'),
            'create' => CreateSermonNote::route('/create'),
            'edit' => EditSermonNote::route('/{record}/edit'),
        ];
    }
}
