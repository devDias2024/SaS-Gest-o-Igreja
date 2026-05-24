<?php

namespace App\Filament\Resources\Sermons\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class SermonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Pregacao')->tabs([
                Tab::make('Dados')->schema([
                    Grid::make(['default' => 1, 'md' => 2])->schema([
                        TextInput::make('title')->label('Titulo')->required()->live(onBlur: true)->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state)))->maxLength(255)->columnSpanFull(),
                        TextInput::make('slug')->label('Link amigavel')->unique(ignoreRecord: true)->maxLength(255),
                        DateTimePicker::make('preached_at')->label('Data do culto')->native(false),
                        Select::make('sermon_category_id')->label('Categoria')->relationship('category', 'name')->searchable()->preload(),
                        Select::make('sermon_series_id')->label('Serie')->relationship('series', 'title')->searchable()->preload(),
                        Select::make('preacher_id')->label('Pregador')->relationship('preacher', 'name')->searchable()->preload(),
                        TextInput::make('scripture_reference')->label('Texto biblico')->maxLength(255),
                    ]),
                ]),
                Tab::make('Publicacao')->schema([
                    Grid::make(['default' => 1, 'md' => 2])->schema([
                        Select::make('status')->label('Status')->default('draft')->required()->options([
                            'draft' => 'Rascunho',
                            'published' => 'Publicado',
                            'archived' => 'Arquivado',
                        ]),
                        Select::make('visibility')->label('Visibilidade')->default('public')->required()->options([
                            'public' => 'Publico',
                            'members' => 'Somente membros',
                            'private' => 'Privado',
                        ]),
                        Toggle::make('allow_download')->label('Permitir download')->default(false),
                        Toggle::make('allow_sharing')->label('Permitir compartilhamento')->default(true),
                        TagsInput::make('tags')->label('Tags')->placeholder('Fé Inabalável')->columnSpanFull(),
                        Textarea::make('summary')->label('Resumo')->rows(6)->columnSpanFull(),
                    ]),
                ]),
                Tab::make('Estatisticas')->schema([
                    Grid::make(['default' => 1, 'md' => 2])->schema([
                        TextInput::make('view_count')->label('Visualizacoes')->numeric()->default(0),
                        TextInput::make('download_count')->label('Downloads')->numeric()->default(0),
                    ]),
                ]),
            ])->persistTabInQueryString()->columnSpanFull(),
        ]);
    }
}
