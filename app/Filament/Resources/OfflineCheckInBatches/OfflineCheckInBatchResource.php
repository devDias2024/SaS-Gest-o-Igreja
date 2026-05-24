<?php

namespace App\Filament\Resources\OfflineCheckInBatches;

use App\Filament\Resources\OfflineCheckInBatches\Pages\CreateOfflineCheckInBatch;
use App\Filament\Resources\OfflineCheckInBatches\Pages\EditOfflineCheckInBatch;
use App\Filament\Resources\OfflineCheckInBatches\Pages\ListOfflineCheckInBatches;
use App\Filament\Resources\OfflineCheckInBatches\Schemas\OfflineCheckInBatchForm;
use App\Filament\Resources\OfflineCheckInBatches\Tables\OfflineCheckInBatchesTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\OfflineCheckInBatch;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class OfflineCheckInBatchResource extends Resource
{
    protected static ?string $model = OfflineCheckInBatch::class;

    protected static string|UnitEnum|null $navigationGroup = 'Eventos & Cultos';

    protected static ?string $navigationLabel = 'Offline';

    protected static ?string $modelLabel = 'Lote offline';

    protected static ?string $pluralModelLabel = 'Lotes offline';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return OfflineCheckInBatchForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OfflineCheckInBatchesTable::configure($table);
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
            'index' => ListOfflineCheckInBatches::route('/'),
            'create' => CreateOfflineCheckInBatch::route('/create'),
            'edit' => EditOfflineCheckInBatch::route('/{record}/edit'),
        ];
    }
}
