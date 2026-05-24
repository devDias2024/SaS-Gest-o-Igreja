<?php

namespace App\Filament\Resources\MealServices;

use App\Filament\Resources\MealServices\Pages\CreateMealService;
use App\Filament\Resources\MealServices\Pages\EditMealService;
use App\Filament\Resources\MealServices\Pages\ListMealServices;
use App\Filament\Resources\MealServices\Schemas\MealServiceForm;
use App\Filament\Resources\MealServices\Tables\MealServicesTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\MealService;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class MealServiceResource extends Resource
{
    protected static ?string $model = MealService::class;

    protected static string|UnitEnum|null $navigationGroup = 'Refeitorio & Despensa';

    protected static ?string $navigationLabel = 'Refeicoes servidas';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return MealServiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MealServicesTable::configure($table);
    }

    public static function getPages(): array
    {
        return ['index' => ListMealServices::route('/'), 'create' => CreateMealService::route('/create'), 'edit' => EditMealService::route('/{record}/edit')];
    }
}
