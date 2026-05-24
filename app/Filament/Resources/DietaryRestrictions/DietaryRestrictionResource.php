<?php

namespace App\Filament\Resources\DietaryRestrictions;

use App\Filament\Resources\DietaryRestrictions\Pages\CreateDietaryRestriction;
use App\Filament\Resources\DietaryRestrictions\Pages\EditDietaryRestriction;
use App\Filament\Resources\DietaryRestrictions\Pages\ListDietaryRestrictions;
use App\Filament\Resources\DietaryRestrictions\Schemas\DietaryRestrictionForm;
use App\Filament\Resources\DietaryRestrictions\Tables\DietaryRestrictionsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\DietaryRestriction;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class DietaryRestrictionResource extends Resource
{
    protected static ?string $model = DietaryRestriction::class;

    protected static string|UnitEnum|null $navigationGroup = 'Refeitorio & Despensa';

    protected static ?string $navigationLabel = 'Restricoes alimentares';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return DietaryRestrictionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DietaryRestrictionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDietaryRestrictions::route('/'),
            'create' => CreateDietaryRestriction::route('/create'),
            'edit' => EditDietaryRestriction::route('/{record}/edit'),
        ];
    }
}
