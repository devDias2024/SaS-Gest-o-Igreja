<?php

namespace App\Filament\Resources\PublicContacts;

use App\Filament\Resources\PublicContacts\Pages\CreatePublicContact;
use App\Filament\Resources\PublicContacts\Pages\EditPublicContact;
use App\Filament\Resources\PublicContacts\Pages\ListPublicContacts;
use App\Filament\Resources\PublicContacts\Schemas\PublicContactForm;
use App\Filament\Resources\PublicContacts\Tables\PublicContactsTable;
use App\Filament\Resources\SecuredResource as Resource;
use App\Models\PublicContact;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class PublicContactResource extends Resource
{
    protected static ?string $model = PublicContact::class;

    protected static string|UnitEnum|null $navigationGroup = 'Site Publico';

    protected static ?string $navigationLabel = 'Contatos do site';

    protected static ?string $modelLabel = 'Contato do site';

    protected static ?string $pluralModelLabel = 'Contatos do site';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return PublicContactForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PublicContactsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where(function (Builder $query): void {
                $query->where('source', '!=', 'prayer')
                    ->where(fn (Builder $query): Builder => $query
                        ->whereNull('subject')
                        ->orWhere('subject', '!=', 'Pedido de oracao pelo site'));
            });
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPublicContacts::route('/'),
            'create' => CreatePublicContact::route('/create'),
            'edit' => EditPublicContact::route('/{record}/edit'),
        ];
    }
}
