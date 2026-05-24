<?php

namespace App\Filament\Resources\SitePages\Pages;

use App\Filament\Resources\SitePages\Schemas\SitePageForm;
use App\Filament\Resources\SitePages\SitePageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSitePage extends CreateRecord
{
    protected static string $resource = SitePageResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return SitePageForm::fillVisualEditorData($data);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return SitePageForm::mergeVisualEditorData($data);
    }
}
