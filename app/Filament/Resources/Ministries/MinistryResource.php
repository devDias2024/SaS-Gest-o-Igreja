<?php

namespace App\Filament\Resources\Ministries;

use App\Filament\Resources\Ministries\Pages\CreateMinistry;
use App\Filament\Resources\Ministries\Pages\EditMinistry;
use App\Filament\Resources\Ministries\Pages\ListMinistries;
use App\Filament\Resources\Ministries\Schemas\MinistryForm;
use App\Filament\Resources\Ministries\Tables\MinistriesTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\Ministry;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class MinistryResource extends Resource
{
    protected static ?string $model = Ministry::class;

    protected static string|UnitEnum|null $navigationGroup = 'Ministerios & Celulas';

    protected static ?string $navigationLabel = 'Ministerios';

    protected static ?string $modelLabel = 'Ministerio';

    protected static ?string $pluralModelLabel = 'Ministerios';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return MinistryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MinistriesTable::configure($table);
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
            'index' => ListMinistries::route('/'),
            'create' => CreateMinistry::route('/create'),
            'edit' => EditMinistry::route('/{record}/edit'),
        ];
    }
}
