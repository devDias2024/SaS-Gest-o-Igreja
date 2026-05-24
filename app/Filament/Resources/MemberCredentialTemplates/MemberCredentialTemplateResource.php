<?php

namespace App\Filament\Resources\MemberCredentialTemplates;

use App\Filament\Resources\MemberCredentialTemplates\Pages\CreateMemberCredentialTemplate;
use App\Filament\Resources\MemberCredentialTemplates\Pages\EditMemberCredentialTemplate;
use App\Filament\Resources\MemberCredentialTemplates\Pages\ListMemberCredentialTemplates;
use App\Filament\Resources\MemberCredentialTemplates\Schemas\MemberCredentialTemplateForm;
use App\Filament\Resources\MemberCredentialTemplates\Tables\MemberCredentialTemplatesTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\MemberCredentialTemplate;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class MemberCredentialTemplateResource extends Resource
{
    protected static ?string $model = MemberCredentialTemplate::class;

    protected static string|UnitEnum|null $navigationGroup = 'Gestao de Membros';

    protected static ?string $navigationLabel = 'Modelos de credencial';

    protected static ?string $modelLabel = 'Modelo de credencial';

    protected static ?string $pluralModelLabel = 'Modelos de credencial';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return MemberCredentialTemplateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MemberCredentialTemplatesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMemberCredentialTemplates::route('/'),
            'create' => CreateMemberCredentialTemplate::route('/create'),
            'edit' => EditMemberCredentialTemplate::route('/{record}/edit'),
        ];
    }
}
