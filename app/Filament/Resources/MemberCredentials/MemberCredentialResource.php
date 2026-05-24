<?php

namespace App\Filament\Resources\MemberCredentials;

use App\Filament\Resources\MemberCredentials\Pages\CreateMemberCredential;
use App\Filament\Resources\MemberCredentials\Pages\EditMemberCredential;
use App\Filament\Resources\MemberCredentials\Pages\ListMemberCredentials;
use App\Filament\Resources\MemberCredentials\Schemas\MemberCredentialForm;
use App\Filament\Resources\MemberCredentials\Tables\MemberCredentialsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\MemberCredential;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class MemberCredentialResource extends Resource
{
    protected static ?string $model = MemberCredential::class;

    protected static string|UnitEnum|null $navigationGroup = 'Gestao de Membros';

    protected static ?string $navigationLabel = 'Credenciais';

    protected static ?string $modelLabel = 'Credencial';

    protected static ?string $pluralModelLabel = 'Credenciais';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return MemberCredentialForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MemberCredentialsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMemberCredentials::route('/'),
            'create' => CreateMemberCredential::route('/create'),
            'edit' => EditMemberCredential::route('/{record}/edit'),
        ];
    }
}
