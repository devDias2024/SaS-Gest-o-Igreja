<?php

namespace App\Filament\Resources\OnlineDonations;

use App\Filament\Resources\OnlineDonations\Pages\CreateOnlineDonation;
use App\Filament\Resources\OnlineDonations\Pages\EditOnlineDonation;
use App\Filament\Resources\OnlineDonations\Pages\ListOnlineDonations;
use App\Filament\Resources\OnlineDonations\Schemas\OnlineDonationForm;
use App\Filament\Resources\OnlineDonations\Tables\OnlineDonationsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\OnlineDonation;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class OnlineDonationResource extends Resource
{
    protected static ?string $model = OnlineDonation::class;

    protected static string|UnitEnum|null $navigationGroup = 'Financeiro';

    protected static ?string $navigationLabel = 'Doacoes online';

    protected static ?string $modelLabel = 'Doacao online';

    protected static ?string $pluralModelLabel = 'Doacoes online';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return OnlineDonationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OnlineDonationsTable::configure($table);
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
            'index' => ListOnlineDonations::route('/'),
            'create' => CreateOnlineDonation::route('/create'),
            'edit' => EditOnlineDonation::route('/{record}/edit'),
        ];
    }
}
