<?php

namespace App\Filament\Resources\FoodDonations;

use App\Filament\Resources\FoodDonations\Pages\CreateFoodDonation;
use App\Filament\Resources\FoodDonations\Pages\EditFoodDonation;
use App\Filament\Resources\FoodDonations\Pages\ListFoodDonations;
use App\Filament\Resources\FoodDonations\Schemas\FoodDonationForm;
use App\Filament\Resources\FoodDonations\Tables\FoodDonationsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\FoodDonation;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class FoodDonationResource extends Resource
{
    protected static ?string $model = FoodDonation::class;

    protected static string|UnitEnum|null $navigationGroup = 'Refeitorio & Despensa';

    protected static ?string $navigationLabel = 'Doacoes de alimentos';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return FoodDonationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FoodDonationsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFoodDonations::route('/'),
            'create' => CreateFoodDonation::route('/create'),
            'edit' => EditFoodDonation::route('/{record}/edit'),
        ];
    }
}
