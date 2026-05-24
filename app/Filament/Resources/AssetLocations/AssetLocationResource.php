<?php

namespace App\Filament\Resources\AssetLocations;

use App\Filament\Resources\AssetLocations\Pages\CreateAssetLocation;
use App\Filament\Resources\AssetLocations\Pages\EditAssetLocation;
use App\Filament\Resources\AssetLocations\Pages\ListAssetLocations;
use App\Filament\Resources\AssetLocations\Schemas\AssetLocationForm;
use App\Filament\Resources\AssetLocations\Tables\AssetLocationsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\AssetLocation;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class AssetLocationResource extends Resource
{
    protected static ?string $model = AssetLocation::class;

    protected static string|UnitEnum|null $navigationGroup = 'Patrimonio & Estoque';

    protected static ?string $navigationLabel = 'Locais';

    protected static ?string $modelLabel = 'Local';

    protected static ?string $pluralModelLabel = 'Locais';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return AssetLocationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssetLocationsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAssetLocations::route('/'),
            'create' => CreateAssetLocation::route('/create'),
            'edit' => EditAssetLocation::route('/{record}/edit'),
        ];
    }
}
