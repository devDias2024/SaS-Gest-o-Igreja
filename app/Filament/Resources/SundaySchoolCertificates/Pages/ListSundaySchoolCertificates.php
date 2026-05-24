<?php

namespace App\Filament\Resources\SundaySchoolCertificates\Pages;

use App\Filament\Resources\SundaySchoolCertificates\SundaySchoolCertificateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSundaySchoolCertificates extends ListRecords
{
    protected static string $resource = SundaySchoolCertificateResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
