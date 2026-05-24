<?php

namespace App\Filament\Resources\SundaySchoolCertificates;

use App\Filament\Resources\SecuredResource as Resource;
use App\Filament\Resources\SundaySchoolCertificates\Pages\CreateSundaySchoolCertificate;
use App\Filament\Resources\SundaySchoolCertificates\Pages\EditSundaySchoolCertificate;
use App\Filament\Resources\SundaySchoolCertificates\Pages\ListSundaySchoolCertificates;
use App\Filament\Resources\SundaySchoolCertificates\Schemas\SundaySchoolCertificateForm;
use App\Filament\Resources\SundaySchoolCertificates\Tables\SundaySchoolCertificatesTable;
use App\Models\SundaySchoolCertificate;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SundaySchoolCertificateResource extends Resource
{
    protected static ?string $model = SundaySchoolCertificate::class;

    protected static string|UnitEnum|null $navigationGroup = 'Escola Dominical';

    protected static ?string $navigationLabel = 'Certificados';

    protected static ?string $modelLabel = 'Certificado';

    protected static ?string $pluralModelLabel = 'Certificados';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return SundaySchoolCertificateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SundaySchoolCertificatesTable::configure($table);
    }

    public static function getPages(): array
    {
        return ['index' => ListSundaySchoolCertificates::route('/'), 'create' => CreateSundaySchoolCertificate::route('/create'), 'edit' => EditSundaySchoolCertificate::route('/{record}/edit')];
    }
}
