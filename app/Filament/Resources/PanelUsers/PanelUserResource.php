<?php

namespace App\Filament\Resources\PanelUsers;

use App\Filament\Resources\PanelUsers\Pages\CreatePanelUser;
use App\Filament\Resources\PanelUsers\Pages\EditPanelUser;
use App\Filament\Resources\PanelUsers\Pages\ListPanelUsers;
use App\Filament\Resources\PanelUsers\Schemas\PanelUserForm;
use App\Filament\Resources\PanelUsers\Tables\PanelUsersTable;
use App\Filament\Resources\SecuredResource;
use App\Models\User;
use App\Services\PanelModuleRegistry;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class PanelUserResource extends SecuredResource
{
    protected static ?string $model = User::class;

    protected static string|UnitEnum|null $navigationGroup = PanelModuleRegistry::SETTINGS_LABEL;

    protected static ?string $navigationLabel = 'Usuarios do painel';

    protected static ?string $modelLabel = 'Usuario administrativo';

    protected static ?string $pluralModelLabel = 'Usuarios do painel';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return PanelUserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PanelUsersTable::configure($table);
    }

    public static function canDelete(Model $record): bool
    {
        if ($record->is(auth()->user())) {
            return false;
        }

        if ($record->is_super_admin && User::query()->where('is_super_admin', true)->count() === 1) {
            return false;
        }

        return parent::canDelete($record);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPanelUsers::route('/'),
            'create' => CreatePanelUser::route('/create'),
            'edit' => EditPanelUser::route('/{record}/edit'),
        ];
    }
}
