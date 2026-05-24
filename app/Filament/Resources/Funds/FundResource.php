<?php

namespace App\Filament\Resources\Funds;

use App\Filament\Resources\Funds\Pages\CreateFund;
use App\Filament\Resources\Funds\Pages\EditFund;
use App\Filament\Resources\Funds\Pages\ListFunds;
use App\Filament\Resources\Funds\Schemas\FundForm;
use App\Filament\Resources\Funds\Tables\FundsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\Fund;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class FundResource extends Resource
{
    protected static ?string $model = Fund::class;

    protected static string|UnitEnum|null $navigationGroup = 'Financeiro';

    protected static ?string $navigationLabel = 'Fundos';

    protected static ?string $modelLabel = 'Fundo';

    protected static ?string $pluralModelLabel = 'Fundos';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return FundForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FundsTable::configure($table);
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
            'index' => ListFunds::route('/'),
            'create' => CreateFund::route('/create'),
            'edit' => EditFund::route('/{record}/edit'),
        ];
    }
}
