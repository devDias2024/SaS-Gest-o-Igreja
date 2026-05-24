<?php

namespace App\Filament\Resources\EventVolunteerAssignments;

use App\Filament\Resources\EventVolunteerAssignments\Pages\CreateEventVolunteerAssignment;
use App\Filament\Resources\EventVolunteerAssignments\Pages\EditEventVolunteerAssignment;
use App\Filament\Resources\EventVolunteerAssignments\Pages\ListEventVolunteerAssignments;
use App\Filament\Resources\EventVolunteerAssignments\Schemas\EventVolunteerAssignmentForm;
use App\Filament\Resources\EventVolunteerAssignments\Tables\EventVolunteerAssignmentsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\EventVolunteerAssignment;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class EventVolunteerAssignmentResource extends Resource
{
    protected static ?string $model = EventVolunteerAssignment::class;

    protected static string|UnitEnum|null $navigationGroup = 'Eventos & Cultos';

    protected static ?string $navigationLabel = 'Escalas';

    protected static ?string $modelLabel = 'Escala';

    protected static ?string $pluralModelLabel = 'Escalas';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return EventVolunteerAssignmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventVolunteerAssignmentsTable::configure($table);
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
            'index' => ListEventVolunteerAssignments::route('/'),
            'create' => CreateEventVolunteerAssignment::route('/create'),
            'edit' => EditEventVolunteerAssignment::route('/{record}/edit'),
        ];
    }
}
