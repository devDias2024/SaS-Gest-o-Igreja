<?php

namespace App\Filament\Resources\ChildProfiles;

use App\Filament\Resources\ChildProfiles\Pages\CreateChildProfile;
use App\Filament\Resources\ChildProfiles\Pages\EditChildProfile;
use App\Filament\Resources\ChildProfiles\Pages\ListChildProfiles;
use App\Filament\Resources\ChildProfiles\Schemas\ChildProfileForm;
use App\Filament\Resources\ChildProfiles\Tables\ChildProfilesTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\ChildProfile;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class ChildProfileResource extends Resource
{
    protected static ?string $model = ChildProfile::class;

    protected static string|UnitEnum|null $navigationGroup = 'Criancas & Seguranca';

    protected static ?string $navigationLabel = 'Criancas';

    protected static ?string $modelLabel = 'Crianca';

    protected static ?string $pluralModelLabel = 'Criancas';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return ChildProfileForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ChildProfilesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListChildProfiles::route('/'),
            'create' => CreateChildProfile::route('/create'),
            'edit' => EditChildProfile::route('/{record}/edit'),
        ];
    }
}
