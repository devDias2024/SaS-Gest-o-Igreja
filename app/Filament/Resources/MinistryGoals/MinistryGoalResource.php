<?php

namespace App\Filament\Resources\MinistryGoals;

use App\Filament\Resources\MinistryGoals\Pages\CreateMinistryGoal;
use App\Filament\Resources\MinistryGoals\Pages\EditMinistryGoal;
use App\Filament\Resources\MinistryGoals\Pages\ListMinistryGoals;
use App\Filament\Resources\MinistryGoals\Schemas\MinistryGoalForm;
use App\Filament\Resources\MinistryGoals\Tables\MinistryGoalsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\MinistryGoal;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class MinistryGoalResource extends Resource
{
    protected static ?string $model = MinistryGoal::class;

    protected static string|UnitEnum|null $navigationGroup = 'Ministerios & Celulas';

    protected static ?string $navigationLabel = 'Metas';

    protected static ?string $modelLabel = 'Meta';

    protected static ?string $pluralModelLabel = 'Metas';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return MinistryGoalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MinistryGoalsTable::configure($table);
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
            'index' => ListMinistryGoals::route('/'),
            'create' => CreateMinistryGoal::route('/create'),
            'edit' => EditMinistryGoal::route('/{record}/edit'),
        ];
    }
}
