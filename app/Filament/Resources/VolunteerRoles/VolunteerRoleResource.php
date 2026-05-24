<?php

namespace App\Filament\Resources\VolunteerRoles;

use App\Filament\Resources\SecuredResource as Resource;
use App\Filament\Resources\VolunteerRoles\Pages\CreateVolunteerRole;
use App\Filament\Resources\VolunteerRoles\Pages\EditVolunteerRole;
use App\Filament\Resources\VolunteerRoles\Pages\ListVolunteerRoles;
use App\Filament\Resources\VolunteerRoles\Schemas\VolunteerRoleForm;
use App\Filament\Resources\VolunteerRoles\Tables\VolunteerRolesTable;
use App\Models\VolunteerRole;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class VolunteerRoleResource extends Resource
{
    protected static ?string $model = VolunteerRole::class;

    protected static string|UnitEnum|null $navigationGroup = 'Eventos & Cultos';

    protected static ?string $navigationLabel = 'Funcoes da escala';

    protected static ?string $modelLabel = 'Funcao da escala';

    protected static ?string $pluralModelLabel = 'Funcoes da escala';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return VolunteerRoleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VolunteerRolesTable::configure($table);
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
            'index' => ListVolunteerRoles::route('/'),
            'create' => CreateVolunteerRole::route('/create'),
            'edit' => EditVolunteerRole::route('/{record}/edit'),
        ];
    }
}
