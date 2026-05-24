<?php

namespace App\Filament\Resources\ApiKeys;

use App\Filament\Resources\ApiKeys\Pages\CreateApiKey;
use App\Filament\Resources\ApiKeys\Pages\EditApiKey;
use App\Filament\Resources\ApiKeys\Pages\ListApiKeys;
use App\Filament\Resources\ApiKeys\Schemas\ApiKeyForm;
use App\Filament\Resources\ApiKeys\Tables\ApiKeysTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\ApiKey;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class ApiKeyResource extends Resource
{
    protected static ?string $model = ApiKey::class;

    protected static string|UnitEnum|null $navigationGroup = 'API & Webhooks';

    protected static ?string $navigationLabel = 'Chaves de API';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return ApiKeyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApiKeysTable::configure($table);
    }

    public static function getPages(): array
    {
        return ['index' => ListApiKeys::route('/'), 'create' => CreateApiKey::route('/create'), 'edit' => EditApiKey::route('/{record}/edit')];
    }
}
