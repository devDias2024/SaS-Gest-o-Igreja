<?php

namespace App\Filament\Resources\SermonShareLinks;

use App\Filament\Resources\SecuredResource as Resource;
use App\Filament\Resources\SermonShareLinks\Pages\CreateSermonShareLink;
use App\Filament\Resources\SermonShareLinks\Pages\EditSermonShareLink;
use App\Filament\Resources\SermonShareLinks\Pages\ListSermonShareLinks;
use App\Filament\Resources\SermonShareLinks\Schemas\SermonShareLinkForm;
use App\Filament\Resources\SermonShareLinks\Tables\SermonShareLinksTable;
use App\Models\SermonShareLink;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SermonShareLinkResource extends Resource
{
    protected static ?string $model = SermonShareLink::class;

    protected static string|UnitEnum|null $navigationGroup = 'Biblioteca de Cultos';

    protected static ?string $navigationLabel = 'Links';

    protected static ?string $modelLabel = 'Link';

    protected static ?string $pluralModelLabel = 'Links';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return SermonShareLinkForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SermonShareLinksTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSermonShareLinks::route('/'),
            'create' => CreateSermonShareLink::route('/create'),
            'edit' => EditSermonShareLink::route('/{record}/edit'),
        ];
    }
}
