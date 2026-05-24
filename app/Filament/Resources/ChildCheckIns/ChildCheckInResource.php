<?php

namespace App\Filament\Resources\ChildCheckIns;

use App\Filament\Resources\ChildCheckIns\Pages\CreateChildCheckIn;
use App\Filament\Resources\ChildCheckIns\Pages\EditChildCheckIn;
use App\Filament\Resources\ChildCheckIns\Pages\ListChildCheckIns;
use App\Filament\Resources\ChildCheckIns\Schemas\ChildCheckInForm;
use App\Filament\Resources\ChildCheckIns\Tables\ChildCheckInsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\ChildCheckIn;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class ChildCheckInResource extends Resource
{
    protected static ?string $model = ChildCheckIn::class;

    protected static string|UnitEnum|null $navigationGroup = 'Criancas & Seguranca';

    protected static ?string $navigationLabel = 'Check-ins';

    protected static ?string $modelLabel = 'Check-in infantil';

    protected static ?string $pluralModelLabel = 'Check-ins infantis';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return ChildCheckInForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ChildCheckInsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListChildCheckIns::route('/'),
            'create' => CreateChildCheckIn::route('/create'),
            'edit' => EditChildCheckIn::route('/{record}/edit'),
        ];
    }
}
