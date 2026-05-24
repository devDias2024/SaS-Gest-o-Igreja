<?php

namespace App\Filament\Resources\EventLocations;

use App\Filament\Resources\EventLocations\Pages\CreateEventLocation;
use App\Filament\Resources\EventLocations\Pages\EditEventLocation;
use App\Filament\Resources\EventLocations\Pages\ListEventLocations;
use App\Filament\Resources\EventLocations\Schemas\EventLocationForm;
use App\Filament\Resources\EventLocations\Tables\EventLocationsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\EventLocation;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class EventLocationResource extends Resource
{
    protected static ?string $model = EventLocation::class;

    protected static string|UnitEnum|null $navigationGroup = 'Eventos & Cultos';

    protected static ?string $navigationLabel = 'Locais';

    protected static ?string $modelLabel = 'Local';

    protected static ?string $pluralModelLabel = 'Locais';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return EventLocationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventLocationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEventLocations::route('/'),
            'create' => CreateEventLocation::route('/create'),
            'edit' => EditEventLocation::route('/{record}/edit'),
        ];
    }
}
