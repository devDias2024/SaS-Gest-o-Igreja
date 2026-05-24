<?php

namespace App\Filament\Resources\ApiRequestLogs;

use App\Filament\Resources\ApiRequestLogs\Pages\ListApiRequestLogs;
use App\Filament\Resources\ApiRequestLogs\Tables\ApiRequestLogsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\ApiRequestLog;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class ApiRequestLogResource extends Resource
{
    protected static ?string $model = ApiRequestLog::class;

    protected static string|UnitEnum|null $navigationGroup = 'API & Webhooks';

    protected static ?string $navigationLabel = 'Logs da API';

    protected static ?int $navigationSort = 3;

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
        return ApiRequestLogsTable::configure($table);
    }

    public static function getPages(): array
    {
        return ['index' => ListApiRequestLogs::route('/')];
    }
}
