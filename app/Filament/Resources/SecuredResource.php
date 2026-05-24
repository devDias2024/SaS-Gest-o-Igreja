<?php

namespace App\Filament\Resources;

use App\Services\PanelPermissionService;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;

abstract class SecuredResource extends Resource
{
    public static function canViewAny(): bool
    {
        return static::allows('view') && parent::canViewAny();
    }

    public static function canCreate(): bool
    {
        return static::allows('create') && parent::canCreate();
    }

    public static function canEdit(Model $record): bool
    {
        return static::allows('update') && parent::canEdit($record);
    }

    public static function canDelete(Model $record): bool
    {
        return static::allows('delete') && parent::canDelete($record);
    }

    public static function canDeleteAny(): bool
    {
        return static::allows('delete') && parent::canDeleteAny();
    }

    private static function allows(string $action): bool
    {
        return app(PanelPermissionService::class)->allows(auth()->user(), (string) static::getNavigationGroup(), $action);
    }
}
