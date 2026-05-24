<?php

namespace App\Filament\Resources\ChildEmergencyCalls;

use App\Filament\Resources\ChildEmergencyCalls\Pages\CreateChildEmergencyCall;
use App\Filament\Resources\ChildEmergencyCalls\Pages\EditChildEmergencyCall;
use App\Filament\Resources\ChildEmergencyCalls\Pages\ListChildEmergencyCalls;
use App\Filament\Resources\ChildEmergencyCalls\Schemas\ChildEmergencyCallForm;
use App\Filament\Resources\ChildEmergencyCalls\Tables\ChildEmergencyCallsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\ChildEmergencyCall;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class ChildEmergencyCallResource extends Resource
{
    protected static ?string $model = ChildEmergencyCall::class;

    protected static string|UnitEnum|null $navigationGroup = 'Criancas & Seguranca';

    protected static ?string $navigationLabel = 'Emergencias';

    protected static ?string $modelLabel = 'Chamada de emergencia';

    protected static ?string $pluralModelLabel = 'Chamadas de emergencia';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return ChildEmergencyCallForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ChildEmergencyCallsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListChildEmergencyCalls::route('/'),
            'create' => CreateChildEmergencyCall::route('/create'),
            'edit' => EditChildEmergencyCall::route('/{record}/edit'),
        ];
    }
}
