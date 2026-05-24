<?php

namespace App\Filament\Resources\EventCheckIns;

use App\Filament\Resources\EventCheckIns\Pages\CreateEventCheckIn;
use App\Filament\Resources\EventCheckIns\Pages\EditEventCheckIn;
use App\Filament\Resources\EventCheckIns\Pages\ListEventCheckIns;
use App\Filament\Resources\EventCheckIns\Schemas\EventCheckInForm;
use App\Filament\Resources\EventCheckIns\Tables\EventCheckInsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\EventCheckIn;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class EventCheckInResource extends Resource
{
    protected static ?string $model = EventCheckIn::class;

    protected static string|UnitEnum|null $navigationGroup = 'Eventos & Cultos';

    protected static ?string $navigationLabel = 'Check-ins';

    protected static ?string $modelLabel = 'Check-in';

    protected static ?string $pluralModelLabel = 'Check-ins';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return EventCheckInForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventCheckInsTable::configure($table);
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
            'index' => ListEventCheckIns::route('/'),
            'create' => CreateEventCheckIn::route('/create'),
            'edit' => EditEventCheckIn::route('/{record}/edit'),
        ];
    }
}
