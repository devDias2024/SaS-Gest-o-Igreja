<?php

namespace App\Filament\Resources\PanelSettings;

use App\Filament\Resources\PanelSettings\Pages\CreatePanelSetting;
use App\Filament\Resources\PanelSettings\Pages\EditPanelSetting;
use App\Filament\Resources\PanelSettings\Pages\ListPanelSettings;
use App\Filament\Resources\PanelSettings\Schemas\PanelSettingForm;
use App\Filament\Resources\PanelSettings\Tables\PanelSettingsTable;
use App\Filament\Resources\SecuredResource;
use App\Models\PanelSetting;
use App\Services\PanelModuleRegistry;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class PanelSettingResource extends SecuredResource
{
    protected static ?string $model = PanelSetting::class;

    protected static string|UnitEnum|null $navigationGroup = PanelModuleRegistry::SETTINGS_LABEL;

    protected static ?string $navigationLabel = 'Painel e tema';

    protected static ?string $modelLabel = 'Configuracao do painel';

    protected static ?string $pluralModelLabel = 'Painel e tema';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return PanelSettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PanelSettingsTable::configure($table);
    }

    public static function canCreate(): bool
    {
        return parent::canCreate() && ! PanelSetting::query()->exists();
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPanelSettings::route('/'),
            'create' => CreatePanelSetting::route('/create'),
            'edit' => EditPanelSetting::route('/{record}/edit'),
        ];
    }
}
