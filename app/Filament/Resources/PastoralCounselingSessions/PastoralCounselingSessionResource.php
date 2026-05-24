<?php

namespace App\Filament\Resources\PastoralCounselingSessions;

use App\Filament\Resources\PastoralCounselingSessions\Pages\CreatePastoralCounselingSession;
use App\Filament\Resources\PastoralCounselingSessions\Pages\EditPastoralCounselingSession;
use App\Filament\Resources\PastoralCounselingSessions\Pages\ListPastoralCounselingSessions;
use App\Filament\Resources\PastoralCounselingSessions\Schemas\PastoralCounselingSessionForm;
use App\Filament\Resources\PastoralCounselingSessions\Tables\PastoralCounselingSessionsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\PastoralCounselingSession;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class PastoralCounselingSessionResource extends Resource
{
    protected static ?string $model = PastoralCounselingSession::class;

    protected static string|UnitEnum|null $navigationGroup = 'Aconselhamento Pastoral';

    protected static ?string $navigationLabel = 'Sessoes';

    protected static ?string $modelLabel = 'Sessao';

    protected static ?string $pluralModelLabel = 'Sessoes';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return PastoralCounselingSessionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PastoralCounselingSessionsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->visibleTo(auth()->user());
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPastoralCounselingSessions::route('/'),
            'create' => CreatePastoralCounselingSession::route('/create'),
            'edit' => EditPastoralCounselingSession::route('/{record}/edit'),
        ];
    }
}
