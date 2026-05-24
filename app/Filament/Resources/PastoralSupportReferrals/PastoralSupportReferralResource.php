<?php

namespace App\Filament\Resources\PastoralSupportReferrals;

use App\Filament\Resources\PastoralSupportReferrals\Pages\CreatePastoralSupportReferral;
use App\Filament\Resources\PastoralSupportReferrals\Pages\EditPastoralSupportReferral;
use App\Filament\Resources\PastoralSupportReferrals\Pages\ListPastoralSupportReferrals;
use App\Filament\Resources\PastoralSupportReferrals\Schemas\PastoralSupportReferralForm;
use App\Filament\Resources\PastoralSupportReferrals\Tables\PastoralSupportReferralsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\PastoralSupportReferral;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class PastoralSupportReferralResource extends Resource
{
    protected static ?string $model = PastoralSupportReferral::class;

    protected static string|UnitEnum|null $navigationGroup = 'Aconselhamento Pastoral';

    protected static ?string $navigationLabel = 'Rede de apoio';

    protected static ?string $modelLabel = 'Encaminhamento';

    protected static ?string $pluralModelLabel = 'Encaminhamentos';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return PastoralSupportReferralForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PastoralSupportReferralsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->visibleTo(auth()->user());
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPastoralSupportReferrals::route('/'),
            'create' => CreatePastoralSupportReferral::route('/create'),
            'edit' => EditPastoralSupportReferral::route('/{record}/edit'),
        ];
    }
}
