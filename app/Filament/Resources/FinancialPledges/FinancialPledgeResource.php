<?php

namespace App\Filament\Resources\FinancialPledges;

use App\Filament\Resources\FinancialPledges\Pages\CreateFinancialPledge;
use App\Filament\Resources\FinancialPledges\Pages\EditFinancialPledge;
use App\Filament\Resources\FinancialPledges\Pages\ListFinancialPledges;
use App\Filament\Resources\FinancialPledges\Schemas\FinancialPledgeForm;
use App\Filament\Resources\FinancialPledges\Tables\FinancialPledgesTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\FinancialPledge;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class FinancialPledgeResource extends Resource
{
    protected static ?string $model = FinancialPledge::class;

    protected static string|UnitEnum|null $navigationGroup = 'Financeiro';

    protected static ?string $navigationLabel = 'Promessas';

    protected static ?string $modelLabel = 'Promessa';

    protected static ?string $pluralModelLabel = 'Promessas';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return FinancialPledgeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FinancialPledgesTable::configure($table);
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
            'index' => ListFinancialPledges::route('/'),
            'create' => CreateFinancialPledge::route('/create'),
            'edit' => EditFinancialPledge::route('/{record}/edit'),
        ];
    }
}
