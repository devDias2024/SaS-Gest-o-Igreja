<?php

namespace App\Filament\Resources\Sermons;

use App\Filament\Resources\SecuredResource as Resource;
use App\Filament\Resources\Sermons\Pages\CreateSermon;
use App\Filament\Resources\Sermons\Pages\EditSermon;
use App\Filament\Resources\Sermons\Pages\ListSermons;
use App\Filament\Resources\Sermons\Schemas\SermonForm;
use App\Filament\Resources\Sermons\Tables\SermonsTable;
use App\Models\Sermon;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SermonResource extends Resource
{
    protected static ?string $model = Sermon::class;

    protected static string|UnitEnum|null $navigationGroup = 'Biblioteca de Cultos';

    protected static ?string $navigationLabel = 'Pregacoes';

    protected static ?string $modelLabel = 'Pregacao';

    protected static ?string $pluralModelLabel = 'Pregacoes';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return SermonForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SermonsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSermons::route('/'),
            'create' => CreateSermon::route('/create'),
            'edit' => EditSermon::route('/{record}/edit'),
        ];
    }
}
