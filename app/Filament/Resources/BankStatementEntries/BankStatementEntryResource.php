<?php

namespace App\Filament\Resources\BankStatementEntries;

use App\Filament\Resources\BankStatementEntries\Pages\CreateBankStatementEntry;
use App\Filament\Resources\BankStatementEntries\Pages\EditBankStatementEntry;
use App\Filament\Resources\BankStatementEntries\Pages\ListBankStatementEntries;
use App\Filament\Resources\BankStatementEntries\Schemas\BankStatementEntryForm;
use App\Filament\Resources\BankStatementEntries\Tables\BankStatementEntriesTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\BankStatementEntry;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class BankStatementEntryResource extends Resource
{
    protected static ?string $model = BankStatementEntry::class;

    protected static string|UnitEnum|null $navigationGroup = 'Financeiro';

    protected static ?string $navigationLabel = 'Conciliação';

    protected static ?string $modelLabel = 'Item de extrato';

    protected static ?string $pluralModelLabel = 'Extrato bancario';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return BankStatementEntryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BankStatementEntriesTable::configure($table);
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
            'index' => ListBankStatementEntries::route('/'),
            'create' => CreateBankStatementEntry::route('/create'),
            'edit' => EditBankStatementEntry::route('/{record}/edit'),
        ];
    }
}
