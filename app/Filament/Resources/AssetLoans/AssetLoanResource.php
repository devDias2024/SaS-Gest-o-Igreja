<?php

namespace App\Filament\Resources\AssetLoans;

use App\Filament\Resources\AssetLoans\Pages\CreateAssetLoan;
use App\Filament\Resources\AssetLoans\Pages\EditAssetLoan;
use App\Filament\Resources\AssetLoans\Pages\ListAssetLoans;
use App\Filament\Resources\AssetLoans\Schemas\AssetLoanForm;
use App\Filament\Resources\AssetLoans\Tables\AssetLoansTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\AssetLoan;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class AssetLoanResource extends Resource
{
    protected static ?string $model = AssetLoan::class;

    protected static string|UnitEnum|null $navigationGroup = 'Patrimonio & Estoque';

    protected static ?string $navigationLabel = 'Emprestimos';

    protected static ?string $modelLabel = 'Emprestimo';

    protected static ?string $pluralModelLabel = 'Emprestimos';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return AssetLoanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssetLoansTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAssetLoans::route('/'),
            'create' => CreateAssetLoan::route('/create'),
            'edit' => EditAssetLoan::route('/{record}/edit'),
        ];
    }
}
