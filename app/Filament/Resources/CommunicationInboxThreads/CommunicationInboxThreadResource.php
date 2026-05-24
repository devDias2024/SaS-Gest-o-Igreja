<?php

namespace App\Filament\Resources\CommunicationInboxThreads;

use App\Filament\Resources\CommunicationInboxThreads\Pages\CreateCommunicationInboxThread;
use App\Filament\Resources\CommunicationInboxThreads\Pages\EditCommunicationInboxThread;
use App\Filament\Resources\CommunicationInboxThreads\Pages\ListCommunicationInboxThreads;
use App\Filament\Resources\CommunicationInboxThreads\Schemas\CommunicationInboxThreadForm;
use App\Filament\Resources\CommunicationInboxThreads\Tables\CommunicationInboxThreadsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\CommunicationInboxThread;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class CommunicationInboxThreadResource extends Resource
{
    protected static ?string $model = CommunicationInboxThread::class;

    protected static string|UnitEnum|null $navigationGroup = 'Comunicacao';

    protected static ?string $navigationLabel = 'Caixa de entrada';

    protected static ?string $modelLabel = 'Conversa';

    protected static ?string $pluralModelLabel = 'Caixa de entrada';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return CommunicationInboxThreadForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CommunicationInboxThreadsTable::configure($table);
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
            'index' => ListCommunicationInboxThreads::route('/'),
            'create' => CreateCommunicationInboxThread::route('/create'),
            'edit' => EditCommunicationInboxThread::route('/{record}/edit'),
        ];
    }
}
