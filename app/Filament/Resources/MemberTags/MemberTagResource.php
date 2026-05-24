<?php

namespace App\Filament\Resources\MemberTags;

use App\Filament\Resources\MemberTags\Pages\CreateMemberTag;
use App\Filament\Resources\MemberTags\Pages\EditMemberTag;
use App\Filament\Resources\MemberTags\Pages\ListMemberTags;
use App\Filament\Resources\MemberTags\Schemas\MemberTagForm;
use App\Filament\Resources\MemberTags\Tables\MemberTagsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\MemberTag;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class MemberTagResource extends Resource
{
    protected static ?string $model = MemberTag::class;

    protected static ?string $navigationLabel = 'Tags';

    protected static ?string $modelLabel = 'Tag';

    protected static ?string $pluralModelLabel = 'Tags';

    protected static string|UnitEnum|null $navigationGroup = 'Gestao de Membros';

    public static function form(Schema $schema): Schema
    {
        return MemberTagForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MemberTagsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMemberTags::route('/'),
            'create' => CreateMemberTag::route('/create'),
            'edit' => EditMemberTag::route('/{record}/edit'),
        ];
    }
}
