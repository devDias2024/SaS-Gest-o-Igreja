<?php

namespace App\Filament\Resources\CommunicationAutomations;

use App\Filament\Resources\CommunicationAutomations\Pages\CreateCommunicationAutomation;
use App\Filament\Resources\CommunicationAutomations\Pages\EditCommunicationAutomation;
use App\Filament\Resources\CommunicationAutomations\Pages\ListCommunicationAutomations;
use App\Filament\Resources\CommunicationAutomations\Schemas\CommunicationAutomationForm;
use App\Filament\Resources\CommunicationAutomations\Tables\CommunicationAutomationsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\CommunicationAutomation;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class CommunicationAutomationResource extends Resource
{
    protected static ?string $model = CommunicationAutomation::class;

    protected static string|UnitEnum|null $navigationGroup = 'Comunicacao';

    protected static ?string $navigationLabel = 'Automacoes';

    protected static ?string $modelLabel = 'Automacao';

    protected static ?string $pluralModelLabel = 'Automacoes';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return CommunicationAutomationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CommunicationAutomationsTable::configure($table);
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
            'index' => ListCommunicationAutomations::route('/'),
            'create' => CreateCommunicationAutomation::route('/create'),
            'edit' => EditCommunicationAutomation::route('/{record}/edit'),
        ];
    }
}
