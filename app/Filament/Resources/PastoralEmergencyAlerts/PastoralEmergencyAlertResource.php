<?php

namespace App\Filament\Resources\PastoralEmergencyAlerts;

use App\Filament\Resources\PastoralEmergencyAlerts\Pages\CreatePastoralEmergencyAlert;
use App\Filament\Resources\PastoralEmergencyAlerts\Pages\EditPastoralEmergencyAlert;
use App\Filament\Resources\PastoralEmergencyAlerts\Pages\ListPastoralEmergencyAlerts;
use App\Filament\Resources\PastoralEmergencyAlerts\Schemas\PastoralEmergencyAlertForm;
use App\Filament\Resources\PastoralEmergencyAlerts\Tables\PastoralEmergencyAlertsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\PastoralEmergencyAlert;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class PastoralEmergencyAlertResource extends Resource
{
    protected static ?string $model = PastoralEmergencyAlert::class;

    protected static string|UnitEnum|null $navigationGroup = 'Aconselhamento Pastoral';

    protected static ?string $navigationLabel = 'Emergencias';

    protected static ?string $modelLabel = 'Emergencia pastoral';

    protected static ?string $pluralModelLabel = 'Emergencias pastorais';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return PastoralEmergencyAlertForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PastoralEmergencyAlertsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->visibleTo(auth()->user());
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPastoralEmergencyAlerts::route('/'),
            'create' => CreatePastoralEmergencyAlert::route('/create'),
            'edit' => EditPastoralEmergencyAlert::route('/{record}/edit'),
        ];
    }
}
