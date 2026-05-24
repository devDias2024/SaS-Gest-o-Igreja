<?php

namespace App\Filament\Resources\Members\Tables;

use App\Filament\Exports\MemberExporter;
use App\Filament\Resources\MemberCredentials\MemberCredentialResource;
use App\Models\Member;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Relaticle\CustomFields\Facades\CustomFields;

class MembersTable
{
    public static function configure(Table $table): Table
    {
        $customFields = CustomFields::table()->forModel(Member::class);

        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with('customFieldValues.customField.options'))
            ->columns([
                ImageColumn::make('photos')
                    ->label('Foto')
                    ->disk('public')
                    ->visibility('public')
                    ->circular()
                    ->stacked()
                    ->limit(1)
                    ->defaultImageUrl(fn ($record): string => self::avatarDataUri($record->full_name)),
                TextColumn::make('full_name')->label('Nome')->searchable()->sortable(),
                TextColumn::make('preferred_name')->label('Apelido')->searchable()->toggleable(),
                TextColumn::make('category.name')->label('Categoria')->badge()->sortable(),
                TextColumn::make('tags.name')->label('Tags')->badge()->separator(',')->toggleable(),
                TextColumn::make('birth_date')->label('Aniversario')->date('d/m/Y')->sortable(),
                TextColumn::make('phone')->label('Telefone')->searchable()->toggleable(),
                TextColumn::make('address_city')->label('Cidade')->searchable()->sortable()->toggleable(),
                TextColumn::make('ministry_role')->label('Cargo')->searchable()->toggleable(),
                TextColumn::make('spiritual_status')
                    ->label('Situacao')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'active' => 'Ativo',
                        'visitor' => 'Visitante',
                        'away' => 'Afastado',
                        'transferred' => 'Transferido',
                        default => 'Nao informado',
                    }),
                TextColumn::make('map_url')
                    ->label('Mapa')
                    ->state(fn ($record): ?string => $record->map_url ? 'Abrir' : null)
                    ->url(fn ($record): ?string => $record->map_url)
                    ->openUrlInNewTab()
                    ->toggleable(),
                ...$customFields->columns()->all(),
            ])
            ->filters([
                SelectFilter::make('member_category_id')
                    ->label('Categoria')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('tags')
                    ->label('Tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                SelectFilter::make('spiritual_status')->label('Situacao')->options([
                    'active' => 'Ativo',
                    'visitor' => 'Visitante',
                    'away' => 'Afastado',
                    'transferred' => 'Transferido',
                ]),
                SelectFilter::make('marital_status')->label('Estado civil')->options([
                    'single' => 'Solteiro(a)',
                    'married' => 'Casado(a)',
                    'divorced' => 'Divorciado(a)',
                    'widowed' => 'Viuvo(a)',
                ]),
                SelectFilter::make('address_state')->label('UF')->options([
                    'AC' => 'AC', 'AL' => 'AL', 'AP' => 'AP', 'AM' => 'AM',
                    'BA' => 'BA', 'CE' => 'CE', 'DF' => 'DF', 'ES' => 'ES',
                    'GO' => 'GO', 'MA' => 'MA', 'MT' => 'MT', 'MS' => 'MS',
                    'MG' => 'MG', 'PA' => 'PA', 'PB' => 'PB', 'PR' => 'PR',
                    'PE' => 'PE', 'PI' => 'PI', 'RJ' => 'RJ', 'RN' => 'RN',
                    'RS' => 'RS', 'RO' => 'RO', 'RR' => 'RR', 'SC' => 'SC',
                    'SP' => 'SP', 'SE' => 'SE', 'TO' => 'TO',
                ]),
                Filter::make('birthdays_this_month')
                    ->label('Aniversariantes do mes')
                    ->query(fn (Builder $query): Builder => $query->whereMonth('birth_date', now()->month)),
                Filter::make('with_map')
                    ->label('Com localizacao no mapa')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('latitude')->whereNotNull('longitude')),
                ...$customFields->filters()->all(),
            ])
            ->recordActions([
                Action::make('issueCredential')
                    ->label('Emitir credencial')
                    ->icon('heroicon-o-identification')
                    ->url(fn ($record): string => MemberCredentialResource::getUrl('create', ['member_id' => $record->id])),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()
                        ->exporter(MemberExporter::class),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected static function avatarDataUri(string $name): string
    {
        $words = preg_split('/\s+/', trim($name)) ?: [];
        $initials = collect($words)
            ->filter()
            ->take(2)
            ->map(fn (string $word): string => mb_strtoupper(mb_substr($word, 0, 1)))
            ->join('');

        $svg = sprintf(
            '<svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 96 96"><rect width="96" height="96" rx="48" fill="#f59e0b"/><text x="50%%" y="54%%" text-anchor="middle" dominant-baseline="middle" font-family="Arial, sans-serif" font-size="34" font-weight="700" fill="#111827">%s</text></svg>',
            e($initials ?: '?'),
        );

        return 'data:image/svg+xml;base64,'.base64_encode($svg);
    }
}
