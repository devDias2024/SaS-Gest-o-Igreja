<?php

namespace App\Filament\Resources\DiningMenus;

use App\Filament\Resources\DiningMenus\Pages\CreateDiningMenu;
use App\Filament\Resources\DiningMenus\Pages\EditDiningMenu;
use App\Filament\Resources\DiningMenus\Pages\ListDiningMenus;
use App\Filament\Resources\DiningMenus\Schemas\DiningMenuForm;
use App\Filament\Resources\DiningMenus\Tables\DiningMenusTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\DiningMenu;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class DiningMenuResource extends Resource
{
    protected static ?string $model = DiningMenu::class;

    protected static string|UnitEnum|null $navigationGroup = 'Refeitorio & Despensa';

    protected static ?string $navigationLabel = 'Cardapios';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return DiningMenuForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DiningMenusTable::configure($table);
    }

    public static function getPages(): array
    {
        return ['index' => ListDiningMenus::route('/'), 'create' => CreateDiningMenu::route('/create'), 'edit' => EditDiningMenu::route('/{record}/edit')];
    }
}
