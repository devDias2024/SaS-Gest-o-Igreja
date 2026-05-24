<?php

namespace App\Filament\Resources\SermonMedia;

use App\Filament\Resources\SecuredResource as Resource;
use App\Filament\Resources\SermonMedia\Pages\CreateSermonMedia;
use App\Filament\Resources\SermonMedia\Pages\EditSermonMedia;
use App\Filament\Resources\SermonMedia\Pages\ListSermonMedia;
use App\Filament\Resources\SermonMedia\Schemas\SermonMediaForm;
use App\Filament\Resources\SermonMedia\Tables\SermonMediaTable;
use App\Models\SermonMedia;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SermonMediaResource extends Resource
{
    protected static ?string $model = SermonMedia::class;

    protected static string|UnitEnum|null $navigationGroup = 'Biblioteca de Cultos';

    protected static ?string $navigationLabel = 'Midias';

    protected static ?string $modelLabel = 'Midia';

    protected static ?string $pluralModelLabel = 'Midias';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return SermonMediaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SermonMediaTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSermonMedia::route('/'),
            'create' => CreateSermonMedia::route('/create'),
            'edit' => EditSermonMedia::route('/{record}/edit'),
        ];
    }
}
