<?php

namespace App\Filament\Resources\ChildAgeGroups;

use App\Filament\Resources\ChildAgeGroups\Pages\CreateChildAgeGroup;
use App\Filament\Resources\ChildAgeGroups\Pages\EditChildAgeGroup;
use App\Filament\Resources\ChildAgeGroups\Pages\ListChildAgeGroups;
use App\Filament\Resources\ChildAgeGroups\Schemas\ChildAgeGroupForm;
use App\Filament\Resources\ChildAgeGroups\Tables\ChildAgeGroupsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\ChildAgeGroup;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class ChildAgeGroupResource extends Resource
{
    protected static ?string $model = ChildAgeGroup::class;

    protected static string|UnitEnum|null $navigationGroup = 'Criancas & Seguranca';

    protected static ?string $navigationLabel = 'Faixas etarias';

    protected static ?string $modelLabel = 'Faixa etaria';

    protected static ?string $pluralModelLabel = 'Faixas etarias';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return ChildAgeGroupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ChildAgeGroupsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListChildAgeGroups::route('/'),
            'create' => CreateChildAgeGroup::route('/create'),
            'edit' => EditChildAgeGroup::route('/{record}/edit'),
        ];
    }
}
