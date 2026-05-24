<?php

namespace App\Filament\Resources\CommunicationMessages;

use App\Filament\Resources\CommunicationMessages\Pages\CreateCommunicationMessage;
use App\Filament\Resources\CommunicationMessages\Pages\EditCommunicationMessage;
use App\Filament\Resources\CommunicationMessages\Pages\ListCommunicationMessages;
use App\Filament\Resources\CommunicationMessages\Schemas\CommunicationMessageForm;
use App\Filament\Resources\CommunicationMessages\Tables\CommunicationMessagesTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\CommunicationMessage;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class CommunicationMessageResource extends Resource
{
    protected static ?string $model = CommunicationMessage::class;

    protected static string|UnitEnum|null $navigationGroup = 'Comunicacao';

    protected static ?string $navigationLabel = 'Mensagens';

    protected static ?string $modelLabel = 'Mensagem';

    protected static ?string $pluralModelLabel = 'Mensagens';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return CommunicationMessageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CommunicationMessagesTable::configure($table);
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
            'index' => ListCommunicationMessages::route('/'),
            'create' => CreateCommunicationMessage::route('/create'),
            'edit' => EditCommunicationMessage::route('/{record}/edit'),
        ];
    }
}
