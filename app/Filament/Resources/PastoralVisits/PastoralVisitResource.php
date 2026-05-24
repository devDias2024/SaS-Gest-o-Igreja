<?php

namespace App\Filament\Resources\PastoralVisits;

use App\Filament\Resources\PastoralVisits\Pages\CreatePastoralVisit;
use App\Filament\Resources\PastoralVisits\Pages\EditPastoralVisit;
use App\Filament\Resources\PastoralVisits\Pages\ListPastoralVisits;
use App\Filament\Resources\PastoralVisits\Schemas\PastoralVisitForm;
use App\Filament\Resources\PastoralVisits\Tables\PastoralVisitsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\PastoralVisit;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class PastoralVisitResource extends Resource
{
    protected static ?string $model = PastoralVisit::class;

    protected static string|UnitEnum|null $navigationGroup = 'Ministerios & Celulas';

    protected static ?string $navigationLabel = 'Visitas pastorais';

    protected static ?string $modelLabel = 'Visita pastoral';

    protected static ?string $pluralModelLabel = 'Visitas pastorais';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return PastoralVisitForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PastoralVisitsTable::configure($table);
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
            'index' => ListPastoralVisits::route('/'),
            'create' => CreatePastoralVisit::route('/create'),
            'edit' => EditPastoralVisit::route('/{record}/edit'),
        ];
    }
}
