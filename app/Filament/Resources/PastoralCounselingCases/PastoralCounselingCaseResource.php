<?php

namespace App\Filament\Resources\PastoralCounselingCases;

use App\Filament\Resources\PastoralCounselingCases\Pages\CreatePastoralCounselingCase;
use App\Filament\Resources\PastoralCounselingCases\Pages\EditPastoralCounselingCase;
use App\Filament\Resources\PastoralCounselingCases\Pages\ListPastoralCounselingCases;
use App\Filament\Resources\PastoralCounselingCases\Schemas\PastoralCounselingCaseForm;
use App\Filament\Resources\PastoralCounselingCases\Tables\PastoralCounselingCasesTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\PastoralCounselingCase;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class PastoralCounselingCaseResource extends Resource
{
    protected static ?string $model = PastoralCounselingCase::class;

    protected static string|UnitEnum|null $navigationGroup = 'Aconselhamento Pastoral';

    protected static ?string $navigationLabel = 'Prontuarios sigilosos';

    protected static ?string $modelLabel = 'Prontuario sigiloso';

    protected static ?string $pluralModelLabel = 'Prontuarios sigilosos';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return PastoralCounselingCaseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PastoralCounselingCasesTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->visibleTo(auth()->user());
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPastoralCounselingCases::route('/'),
            'create' => CreatePastoralCounselingCase::route('/create'),
            'edit' => EditPastoralCounselingCase::route('/{record}/edit'),
        ];
    }
}
