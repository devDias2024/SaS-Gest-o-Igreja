<?php

namespace App\Filament\Resources\CommunicationTemplates;

use App\Filament\Resources\CommunicationTemplates\Pages\CreateCommunicationTemplate;
use App\Filament\Resources\CommunicationTemplates\Pages\EditCommunicationTemplate;
use App\Filament\Resources\CommunicationTemplates\Pages\ListCommunicationTemplates;
use App\Filament\Resources\CommunicationTemplates\Schemas\CommunicationTemplateForm;
use App\Filament\Resources\CommunicationTemplates\Tables\CommunicationTemplatesTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\CommunicationTemplate;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class CommunicationTemplateResource extends Resource
{
    protected static ?string $model = CommunicationTemplate::class;

    protected static string|UnitEnum|null $navigationGroup = 'Comunicacao';

    protected static ?string $navigationLabel = 'Templates';

    protected static ?string $modelLabel = 'Template';

    protected static ?string $pluralModelLabel = 'Templates';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return CommunicationTemplateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CommunicationTemplatesTable::configure($table);
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
            'index' => ListCommunicationTemplates::route('/'),
            'create' => CreateCommunicationTemplate::route('/create'),
            'edit' => EditCommunicationTemplate::route('/{record}/edit'),
        ];
    }
}
