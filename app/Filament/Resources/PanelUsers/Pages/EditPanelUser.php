<?php

namespace App\Filament\Resources\PanelUsers\Pages;

use App\Filament\Resources\PanelUsers\PanelUserResource;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPanelUser extends EditRecord
{
    protected static string $resource = PanelUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->visible(fn (): bool => PanelUserResource::canDelete($this->record)),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($this->record->is(auth()->user())) {
            $data['can_access_panel'] = true;
            $data['is_super_admin'] = true;
        }

        if (
            $this->record->is_super_admin
            && ! ($data['is_super_admin'] ?? false)
            && User::query()->where('is_super_admin', true)->count() === 1
        ) {
            $data['is_super_admin'] = true;
        }

        return $data;
    }
}
