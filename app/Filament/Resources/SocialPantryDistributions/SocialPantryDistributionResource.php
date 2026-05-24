<?php

namespace App\Filament\Resources\SocialPantryDistributions;

use App\Filament\Resources\SecuredResource as Resource;
use App\Filament\Resources\SocialPantryDistributions\Pages\CreateSocialPantryDistribution;
use App\Filament\Resources\SocialPantryDistributions\Pages\EditSocialPantryDistribution;
use App\Filament\Resources\SocialPantryDistributions\Pages\ListSocialPantryDistributions;
use App\Filament\Resources\SocialPantryDistributions\Schemas\SocialPantryDistributionForm;
use App\Filament\Resources\SocialPantryDistributions\Tables\SocialPantryDistributionsTable;
use App\Models\SocialPantryDistribution;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SocialPantryDistributionResource extends Resource
{
    protected static ?string $model = SocialPantryDistribution::class;

    protected static string|UnitEnum|null $navigationGroup = 'Refeitorio & Despensa';

    protected static ?string $navigationLabel = 'Despensa social';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return SocialPantryDistributionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SocialPantryDistributionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSocialPantryDistributions::route('/'),
            'create' => CreateSocialPantryDistribution::route('/create'),
            'edit' => EditSocialPantryDistribution::route('/{record}/edit'),
        ];
    }
}
