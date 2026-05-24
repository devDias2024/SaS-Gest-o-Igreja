<?php

namespace App\Filament\Resources\SermonViews;

use App\Filament\Resources\SecuredResource as Resource;
use App\Filament\Resources\SermonViews\Pages\CreateSermonView;
use App\Filament\Resources\SermonViews\Pages\EditSermonView;
use App\Filament\Resources\SermonViews\Pages\ListSermonViews;
use App\Filament\Resources\SermonViews\Schemas\SermonViewForm;
use App\Filament\Resources\SermonViews\Tables\SermonViewsTable;
use App\Models\SermonView;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SermonViewResource extends Resource
{
    protected static ?string $model = SermonView::class;

    protected static string|UnitEnum|null $navigationGroup = 'Biblioteca de Cultos';

    protected static ?string $navigationLabel = 'Visualizacoes';

    protected static ?string $modelLabel = 'Visualizacao';

    protected static ?string $pluralModelLabel = 'Visualizacoes';

    protected static ?int $navigationSort = 8;

    public static function form(Schema $schema): Schema
    {
        return SermonViewForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SermonViewsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSermonViews::route('/'),
            'create' => CreateSermonView::route('/create'),
            'edit' => EditSermonView::route('/{record}/edit'),
        ];
    }
}
