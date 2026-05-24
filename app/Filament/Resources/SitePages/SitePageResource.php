<?php

namespace App\Filament\Resources\SitePages;

use App\Filament\Resources\SecuredResource as Resource;
use App\Filament\Resources\SitePages\Pages\CreateSitePage;
use App\Filament\Resources\SitePages\Pages\EditSitePage;
use App\Filament\Resources\SitePages\Pages\ListSitePages;
use App\Filament\Resources\SitePages\Schemas\SitePageForm;
use App\Filament\Resources\SitePages\Tables\SitePagesTable;
use App\Models\SitePage;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SitePageResource extends Resource
{
    protected static ?string $model = SitePage::class;

    protected static string|UnitEnum|null $navigationGroup = 'Site Publico';

    protected static ?string $navigationLabel = 'Paginas';

    protected static ?string $modelLabel = 'Pagina';

    protected static ?string $pluralModelLabel = 'Paginas';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return SitePageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SitePagesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSitePages::route('/'),
            'create' => CreateSitePage::route('/create'),
            'edit' => EditSitePage::route('/{record}/edit'),
        ];
    }
}
