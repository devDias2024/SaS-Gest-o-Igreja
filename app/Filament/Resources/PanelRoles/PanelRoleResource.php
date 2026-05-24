<?php

namespace App\Filament\Resources\PanelRoles;

use App\Filament\Resources\PanelRoles\Pages\CreatePanelRole;
use App\Filament\Resources\PanelRoles\Pages\EditPanelRole;
use App\Filament\Resources\PanelRoles\Pages\ListPanelRoles;
use App\Filament\Resources\PanelRoles\Schemas\PanelRoleForm;
use App\Filament\Resources\PanelRoles\Tables\PanelRolesTable;
use App\Filament\Resources\SecuredResource;
use App\Models\PanelRole;
use App\Services\PanelModuleRegistry;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class PanelRoleResource extends SecuredResource
{
    protected static ?string $model = PanelRole::class;

    protected static string|UnitEnum|null $navigationGroup = PanelModuleRegistry::SETTINGS_LABEL;

    protected static ?string $navigationLabel = 'Perfis e permissoes';

    protected static ?string $modelLabel = 'Perfil de acesso';

    protected static ?string $pluralModelLabel = 'Perfis e permissoes';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return PanelRoleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PanelRolesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPanelRoles::route('/'),
            'create' => CreatePanelRole::route('/create'),
            'edit' => EditPanelRole::route('/{record}/edit'),
        ];
    }
}
