<?php

namespace App\Filament\Resources\CellMeetings;

use App\Filament\Resources\CellMeetings\Pages\CreateCellMeeting;
use App\Filament\Resources\CellMeetings\Pages\EditCellMeeting;
use App\Filament\Resources\CellMeetings\Pages\ListCellMeetings;
use App\Filament\Resources\CellMeetings\Schemas\CellMeetingForm;
use App\Filament\Resources\CellMeetings\Tables\CellMeetingsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\CellMeeting;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class CellMeetingResource extends Resource
{
    protected static ?string $model = CellMeeting::class;

    protected static string|UnitEnum|null $navigationGroup = 'Ministerios & Celulas';

    protected static ?string $navigationLabel = 'Reunioes e visitas';

    protected static ?string $modelLabel = 'Reuniao de celula';

    protected static ?string $pluralModelLabel = 'Reunioes de celula';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return CellMeetingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CellMeetingsTable::configure($table);
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
            'index' => ListCellMeetings::route('/'),
            'create' => CreateCellMeeting::route('/create'),
            'edit' => EditCellMeeting::route('/{record}/edit'),
        ];
    }
}
