<?php

namespace App\Filament\Resources\CellMemberships;

use App\Filament\Resources\CellMemberships\Pages\CreateCellMembership;
use App\Filament\Resources\CellMemberships\Pages\EditCellMembership;
use App\Filament\Resources\CellMemberships\Pages\ListCellMemberships;
use App\Filament\Resources\CellMemberships\Schemas\CellMembershipForm;
use App\Filament\Resources\CellMemberships\Tables\CellMembershipsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\CellMembership;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class CellMembershipResource extends Resource
{
    protected static ?string $model = CellMembership::class;

    protected static string|UnitEnum|null $navigationGroup = 'Ministerios & Celulas';

    protected static ?string $navigationLabel = 'Membros das celulas';

    protected static ?string $modelLabel = 'Membro da celula';

    protected static ?string $pluralModelLabel = 'Membros das celulas';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return CellMembershipForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CellMembershipsTable::configure($table);
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
            'index' => ListCellMemberships::route('/'),
            'create' => CreateCellMembership::route('/create'),
            'edit' => EditCellMembership::route('/{record}/edit'),
        ];
    }
}
