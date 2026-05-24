<?php

namespace App\Filament\Resources\ChurchEvents;

use App\Filament\Resources\ChurchEvents\Pages\CreateChurchEvent;
use App\Filament\Resources\ChurchEvents\Pages\EditChurchEvent;
use App\Filament\Resources\ChurchEvents\Pages\ListChurchEvents;
use App\Filament\Resources\ChurchEvents\Schemas\ChurchEventForm;
use App\Filament\Resources\ChurchEvents\Tables\ChurchEventsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\ChurchEvent;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class ChurchEventResource extends Resource
{
    protected static ?string $model = ChurchEvent::class;

    protected static string|UnitEnum|null $navigationGroup = 'Eventos & Cultos';

    protected static ?string $navigationLabel = 'Calendario';

    protected static ?string $modelLabel = 'Evento';

    protected static ?string $pluralModelLabel = 'Eventos';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return ChurchEventForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ChurchEventsTable::configure($table);
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
            'index' => ListChurchEvents::route('/'),
            'create' => CreateChurchEvent::route('/create'),
            'edit' => EditChurchEvent::route('/{record}/edit'),
        ];
    }
}
