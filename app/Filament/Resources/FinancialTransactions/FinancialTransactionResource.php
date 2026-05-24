<?php

namespace App\Filament\Resources\FinancialTransactions;

use App\Filament\Resources\FinancialTransactions\Pages\CreateFinancialTransaction;
use App\Filament\Resources\FinancialTransactions\Pages\EditFinancialTransaction;
use App\Filament\Resources\FinancialTransactions\Pages\ListFinancialTransactions;
use App\Filament\Resources\FinancialTransactions\Schemas\FinancialTransactionForm;
use App\Filament\Resources\FinancialTransactions\Tables\FinancialTransactionsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\FinancialTransaction;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class FinancialTransactionResource extends Resource
{
    protected static ?string $model = FinancialTransaction::class;

    protected static string|UnitEnum|null $navigationGroup = 'Financeiro';

    protected static ?string $navigationLabel = 'Lancamentos';

    protected static ?string $modelLabel = 'Lancamento';

    protected static ?string $pluralModelLabel = 'Lancamentos';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return FinancialTransactionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FinancialTransactionsTable::configure($table);
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
            'index' => ListFinancialTransactions::route('/'),
            'create' => CreateFinancialTransaction::route('/create'),
            'edit' => EditFinancialTransaction::route('/{record}/edit'),
        ];
    }
}
