<?php

namespace App\Filament\Resources\WebhookDeliveries;

use App\Filament\Resources\SecuredResource as Resource;
use App\Filament\Resources\WebhookDeliveries\Pages\ListWebhookDeliveries;
use App\Filament\Resources\WebhookDeliveries\Tables\WebhookDeliveriesTable;
use App\Models\WebhookDelivery;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class WebhookDeliveryResource extends Resource
{
    protected static ?string $model = WebhookDelivery::class;

    protected static string|UnitEnum|null $navigationGroup = 'API & Webhooks';

    protected static ?string $navigationLabel = 'Entregas de webhook';

    protected static ?int $navigationSort = 4;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return WebhookDeliveriesTable::configure($table);
    }

    public static function getPages(): array
    {
        return ['index' => ListWebhookDeliveries::route('/')];
    }
}
