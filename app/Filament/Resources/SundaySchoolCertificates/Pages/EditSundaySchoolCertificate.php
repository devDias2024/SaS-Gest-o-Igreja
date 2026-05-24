<?php

namespace App\Filament\Resources\SundaySchoolCertificates\Pages;

use App\Filament\Resources\SundaySchoolCertificates\SundaySchoolCertificateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSundaySchoolCertificate extends EditRecord
{
    protected static string $resource = SundaySchoolCertificateResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
