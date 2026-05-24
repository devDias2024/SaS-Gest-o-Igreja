<?php

namespace App\Filament\Resources\EventRegistrations;

use App\Filament\Resources\EventRegistrations\Pages\CreateEventRegistration;
use App\Filament\Resources\EventRegistrations\Pages\EditEventRegistration;
use App\Filament\Resources\EventRegistrations\Pages\ListEventRegistrations;
use App\Filament\Resources\EventRegistrations\Schemas\EventRegistrationForm;
use App\Filament\Resources\EventRegistrations\Tables\EventRegistrationsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\EventRegistration;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class EventRegistrationResource extends Resource
{
    protected static ?string $model = EventRegistration::class;

    protected static string|UnitEnum|null $navigationGroup = 'Eventos & Cultos';

    protected static ?string $navigationLabel = 'Inscricoes';

    protected static ?string $modelLabel = 'Inscricao';

    protected static ?string $pluralModelLabel = 'Inscricoes';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return EventRegistrationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventRegistrationsTable::configure($table);
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
            'index' => ListEventRegistrations::route('/'),
            'create' => CreateEventRegistration::route('/create'),
            'edit' => EditEventRegistration::route('/{record}/edit'),
        ];
    }
}
