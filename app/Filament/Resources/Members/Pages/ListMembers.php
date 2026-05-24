<?php

namespace App\Filament\Resources\Members\Pages;

use App\Filament\Exports\MemberExporter;
use App\Filament\Imports\MemberImporter;
use App\Filament\Resources\Members\MemberResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListMembers extends ListRecords
{
    protected static string $resource = MemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->label('Importar CSV')
                ->importer(MemberImporter::class),
            ExportAction::make()
                ->label('Exportar relatorio')
                ->exporter(MemberExporter::class),
            CreateAction::make(),
        ];
    }
}
