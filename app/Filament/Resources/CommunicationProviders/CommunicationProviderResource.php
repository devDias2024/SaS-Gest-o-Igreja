<?php

namespace App\Filament\Resources\CommunicationProviders;

use App\Filament\Resources\CommunicationProviders\Pages\CreateCommunicationProvider;
use App\Filament\Resources\CommunicationProviders\Pages\EditCommunicationProvider;
use App\Filament\Resources\CommunicationProviders\Pages\ListCommunicationProviders;
use App\Filament\Resources\CommunicationProviders\Schemas\CommunicationProviderForm;
use App\Filament\Resources\CommunicationProviders\Tables\CommunicationProvidersTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\CommunicationProvider;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class CommunicationProviderResource extends Resource
{
    protected static ?string $model = CommunicationProvider::class;

    protected static string|UnitEnum|null $navigationGroup = 'Comunicacao';

    protected static ?string $navigationLabel = 'Provedores';

    protected static ?string $modelLabel = 'Provedor';

    protected static ?string $pluralModelLabel = 'Provedores';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return CommunicationProviderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CommunicationProvidersTable::configure($table);
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
            'index' => ListCommunicationProviders::route('/'),
            'create' => CreateCommunicationProvider::route('/create'),
            'edit' => EditCommunicationProvider::route('/{record}/edit'),
        ];
    }
}
