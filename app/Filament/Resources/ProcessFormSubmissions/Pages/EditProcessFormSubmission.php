<?php

namespace App\Filament\Resources\ProcessFormSubmissions\Pages;

use App\Filament\Resources\ProcessFormSubmissions\ProcessFormSubmissionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProcessFormSubmission extends EditRecord
{
    protected static string $resource = ProcessFormSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
