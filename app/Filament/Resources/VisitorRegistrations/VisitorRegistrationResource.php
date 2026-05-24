<?php

namespace App\Filament\Resources\VisitorRegistrations;

use App\Filament\Resources\SecuredResource as Resource;
use App\Filament\Resources\VisitorRegistrations\Pages\CreateVisitorRegistration;
use App\Filament\Resources\VisitorRegistrations\Pages\EditVisitorRegistration;
use App\Filament\Resources\VisitorRegistrations\Pages\ListVisitorRegistrations;
use App\Filament\Resources\VisitorRegistrations\Schemas\VisitorRegistrationForm;
use App\Filament\Resources\VisitorRegistrations\Tables\VisitorRegistrationsTable;
use App\Models\VisitorRegistration;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class VisitorRegistrationResource extends Resource
{
    protected static ?string $model = VisitorRegistration::class;

    protected static string|UnitEnum|null $navigationGroup = 'Site Publico';

    protected static ?string $navigationLabel = 'Visitantes';

    protected static ?string $modelLabel = 'Visitante';

    protected static ?string $pluralModelLabel = 'Visitantes';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return VisitorRegistrationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VisitorRegistrationsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVisitorRegistrations::route('/'),
            'create' => CreateVisitorRegistration::route('/create'),
            'edit' => EditVisitorRegistration::route('/{record}/edit'),
        ];
    }
}
