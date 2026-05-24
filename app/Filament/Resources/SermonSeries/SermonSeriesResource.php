<?php

namespace App\Filament\Resources\SermonSeries;

use App\Filament\Resources\SecuredResource as Resource;
use App\Filament\Resources\SermonSeries\Pages\CreateSermonSeries;
use App\Filament\Resources\SermonSeries\Pages\EditSermonSeries;
use App\Filament\Resources\SermonSeries\Pages\ListSermonSeries;
use App\Filament\Resources\SermonSeries\Schemas\SermonSeriesForm;
use App\Filament\Resources\SermonSeries\Tables\SermonSeriesTable;
use App\Models\SermonSeries;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SermonSeriesResource extends Resource
{
    protected static ?string $model = SermonSeries::class;

    protected static string|UnitEnum|null $navigationGroup = 'Biblioteca de Cultos';

    protected static ?string $navigationLabel = 'Series';

    protected static ?string $modelLabel = 'Serie';

    protected static ?string $pluralModelLabel = 'Series';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return SermonSeriesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SermonSeriesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSermonSeries::route('/'),
            'create' => CreateSermonSeries::route('/create'),
            'edit' => EditSermonSeries::route('/{record}/edit'),
        ];
    }
}
