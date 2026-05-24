<?php

namespace App\Filament\Resources\FinancialCategories;

use App\Filament\Resources\FinancialCategories\Pages\CreateFinancialCategory;
use App\Filament\Resources\FinancialCategories\Pages\EditFinancialCategory;
use App\Filament\Resources\FinancialCategories\Pages\ListFinancialCategories;
use App\Filament\Resources\FinancialCategories\Schemas\FinancialCategoryForm;
use App\Filament\Resources\FinancialCategories\Tables\FinancialCategoriesTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\FinancialCategory;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class FinancialCategoryResource extends Resource
{
    protected static ?string $model = FinancialCategory::class;

    protected static string|UnitEnum|null $navigationGroup = 'Financeiro';

    protected static ?string $navigationLabel = 'Categorias';

    protected static ?string $modelLabel = 'Categoria financeira';

    protected static ?string $pluralModelLabel = 'Categorias financeiras';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return FinancialCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FinancialCategoriesTable::configure($table);
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
            'index' => ListFinancialCategories::route('/'),
            'create' => CreateFinancialCategory::route('/create'),
            'edit' => EditFinancialCategory::route('/{record}/edit'),
        ];
    }
}
