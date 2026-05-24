<?php

namespace App\Filament\Resources\PrayerRequests;

use App\Filament\Resources\PrayerRequests\Pages\CreatePrayerRequest;
use App\Filament\Resources\PrayerRequests\Pages\EditPrayerRequest;
use App\Filament\Resources\PrayerRequests\Pages\ListPrayerRequests;
use App\Filament\Resources\PrayerRequests\Schemas\PrayerRequestForm;
use App\Filament\Resources\PrayerRequests\Tables\PrayerRequestsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\PublicContact;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class PrayerRequestResource extends Resource
{
    protected static ?string $model = PublicContact::class;

    protected static string|UnitEnum|null $navigationGroup = 'Aconselhamento Pastoral';

    protected static ?string $navigationLabel = 'Pedidos de oracao';

    protected static ?string $modelLabel = 'Pedido de oracao';

    protected static ?string $pluralModelLabel = 'Pedidos de oracao';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return PrayerRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PrayerRequestsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where(fn (Builder $query): Builder => $query
                ->where('source', 'prayer')
                ->orWhere('subject', 'Pedido de oracao pelo site'));
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPrayerRequests::route('/'),
            'create' => CreatePrayerRequest::route('/create'),
            'edit' => EditPrayerRequest::route('/{record}/edit'),
        ];
    }
}
