<?php

namespace App\Filament\Resources\ChildPickupAuthorizations;

use App\Filament\Resources\ChildPickupAuthorizations\Pages\CreateChildPickupAuthorization;
use App\Filament\Resources\ChildPickupAuthorizations\Pages\EditChildPickupAuthorization;
use App\Filament\Resources\ChildPickupAuthorizations\Pages\ListChildPickupAuthorizations;
use App\Filament\Resources\ChildPickupAuthorizations\Schemas\ChildPickupAuthorizationForm;
use App\Filament\Resources\ChildPickupAuthorizations\Tables\ChildPickupAuthorizationsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\ChildPickupAuthorization;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class ChildPickupAuthorizationResource extends Resource
{
    protected static ?string $model = ChildPickupAuthorization::class;

    protected static string|UnitEnum|null $navigationGroup = 'Criancas & Seguranca';

    protected static ?string $navigationLabel = 'Autorizacoes';

    protected static ?string $modelLabel = 'Autorizacao de retirada';

    protected static ?string $pluralModelLabel = 'Autorizacoes de retirada';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return ChildPickupAuthorizationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ChildPickupAuthorizationsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListChildPickupAuthorizations::route('/'),
            'create' => CreateChildPickupAuthorization::route('/create'),
            'edit' => EditChildPickupAuthorization::route('/{record}/edit'),
        ];
    }
}
