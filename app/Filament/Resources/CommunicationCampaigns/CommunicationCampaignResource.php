<?php

namespace App\Filament\Resources\CommunicationCampaigns;

use App\Filament\Resources\CommunicationCampaigns\Pages\CreateCommunicationCampaign;
use App\Filament\Resources\CommunicationCampaigns\Pages\EditCommunicationCampaign;
use App\Filament\Resources\CommunicationCampaigns\Pages\ListCommunicationCampaigns;
use App\Filament\Resources\CommunicationCampaigns\Schemas\CommunicationCampaignForm;
use App\Filament\Resources\CommunicationCampaigns\Tables\CommunicationCampaignsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\CommunicationCampaign;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class CommunicationCampaignResource extends Resource
{
    protected static ?string $model = CommunicationCampaign::class;

    protected static string|UnitEnum|null $navigationGroup = 'Comunicacao';

    protected static ?string $navigationLabel = 'Campanhas';

    protected static ?string $modelLabel = 'Campanha';

    protected static ?string $pluralModelLabel = 'Campanhas';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return CommunicationCampaignForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CommunicationCampaignsTable::configure($table);
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
            'index' => ListCommunicationCampaigns::route('/'),
            'create' => CreateCommunicationCampaign::route('/create'),
            'edit' => EditCommunicationCampaign::route('/{record}/edit'),
        ];
    }
}
