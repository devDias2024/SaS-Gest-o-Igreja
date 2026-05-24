<?php

namespace App\Filament\Resources\WebhookEndpoints;

use App\Filament\Resources\SecuredResource as Resource;
use App\Filament\Resources\WebhookEndpoints\Pages\CreateWebhookEndpoint;
use App\Filament\Resources\WebhookEndpoints\Pages\EditWebhookEndpoint;
use App\Filament\Resources\WebhookEndpoints\Pages\ListWebhookEndpoints;
use App\Filament\Resources\WebhookEndpoints\Schemas\WebhookEndpointForm;
use App\Filament\Resources\WebhookEndpoints\Tables\WebhookEndpointsTable;
use App\Models\WebhookEndpoint;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class WebhookEndpointResource extends Resource
{
    protected static ?string $model = WebhookEndpoint::class;

    protected static string|UnitEnum|null $navigationGroup = 'API & Webhooks';

    protected static ?string $navigationLabel = 'Webhooks';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return WebhookEndpointForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WebhookEndpointsTable::configure($table);
    }

    public static function getPages(): array
    {
        return ['index' => ListWebhookEndpoints::route('/'), 'create' => CreateWebhookEndpoint::route('/create'), 'edit' => EditWebhookEndpoint::route('/{record}/edit')];
    }
}
