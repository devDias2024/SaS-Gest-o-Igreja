<?php

namespace App\Filament\Resources\MemberCategories;

use App\Filament\Resources\MemberCategories\Pages\CreateMemberCategory;
use App\Filament\Resources\MemberCategories\Pages\EditMemberCategory;
use App\Filament\Resources\MemberCategories\Pages\ListMemberCategories;
use App\Filament\Resources\MemberCategories\Schemas\MemberCategoryForm;
use App\Filament\Resources\MemberCategories\Tables\MemberCategoriesTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\MemberCategory;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class MemberCategoryResource extends Resource
{
    protected static ?string $model = MemberCategory::class;

    protected static ?string $navigationLabel = 'Categorias';

    protected static ?string $modelLabel = 'Categoria';

    protected static ?string $pluralModelLabel = 'Categorias';

    protected static string|UnitEnum|null $navigationGroup = 'Gestao de Membros';

    public static function form(Schema $schema): Schema
    {
        return MemberCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MemberCategoriesTable::configure($table);
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
            'index' => ListMemberCategories::route('/'),
            'create' => CreateMemberCategory::route('/create'),
            'edit' => EditMemberCategory::route('/{record}/edit'),
        ];
    }
}
