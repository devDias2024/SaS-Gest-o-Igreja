<?php

namespace App\Filament\Resources\SermonCategories;

use App\Filament\Resources\SecuredResource as Resource;
use App\Filament\Resources\SermonCategories\Pages\CreateSermonCategory;
use App\Filament\Resources\SermonCategories\Pages\EditSermonCategory;
use App\Filament\Resources\SermonCategories\Pages\ListSermonCategories;
use App\Filament\Resources\SermonCategories\Schemas\SermonCategoryForm;
use App\Filament\Resources\SermonCategories\Tables\SermonCategoriesTable;
use App\Models\SermonCategory;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SermonCategoryResource extends Resource
{
    protected static ?string $model = SermonCategory::class;

    protected static string|UnitEnum|null $navigationGroup = 'Biblioteca de Cultos';

    protected static ?string $navigationLabel = 'Categorias';

    protected static ?string $modelLabel = 'Categoria';

    protected static ?string $pluralModelLabel = 'Categorias';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return SermonCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SermonCategoriesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSermonCategories::route('/'),
            'create' => CreateSermonCategory::route('/create'),
            'edit' => EditSermonCategory::route('/{record}/edit'),
        ];
    }
}
