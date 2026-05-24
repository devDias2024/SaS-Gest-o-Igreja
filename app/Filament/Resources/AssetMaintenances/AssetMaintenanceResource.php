<?php

namespace App\Filament\Resources\AssetMaintenances;

use App\Filament\Resources\AssetMaintenances\Pages\CreateAssetMaintenance;
use App\Filament\Resources\AssetMaintenances\Pages\EditAssetMaintenance;
use App\Filament\Resources\AssetMaintenances\Pages\ListAssetMaintenances;
use App\Filament\Resources\AssetMaintenances\Schemas\AssetMaintenanceForm;
use App\Filament\Resources\AssetMaintenances\Tables\AssetMaintenancesTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\AssetMaintenance;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class AssetMaintenanceResource extends Resource
{
    protected static ?string $model = AssetMaintenance::class;

    protected static string|UnitEnum|null $navigationGroup = 'Patrimonio & Estoque';

    protected static ?string $navigationLabel = 'Manutencoes';

    protected static ?string $modelLabel = 'Manutencao';

    protected static ?string $pluralModelLabel = 'Manutencoes';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return AssetMaintenanceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssetMaintenancesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAssetMaintenances::route('/'),
            'create' => CreateAssetMaintenance::route('/create'),
            'edit' => EditAssetMaintenance::route('/{record}/edit'),
        ];
    }
}
