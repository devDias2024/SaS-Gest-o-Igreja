<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Post')->tabs([
                Tab::make('Conteudo')->schema([
                    Grid::make(['default' => 1, 'md' => 2])->schema([
                        TextInput::make('title')->label('Titulo')->required()->live(onBlur: true)->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state)))->maxLength(255)->columnSpanFull(),
                        TextInput::make('slug')->label('Link amigavel')->required()->unique(ignoreRecord: true)->maxLength(255),
                        TextInput::make('author_name')->label('Autor')->maxLength(255),
                        TextInput::make('category')->label('Categoria')->maxLength(255),
                        FileUpload::make('cover_image')->label('Capa')->image()->disk('public')->directory('site/blog')->columnSpanFull(),
                        Textarea::make('excerpt')->label('Resumo')->rows(3)->columnSpanFull(),
                        RichEditor::make('content')->label('Conteudo')->required()->columnSpanFull(),
                    ]),
                ]),
                Tab::make('Publicacao')->schema([
                    Grid::make(['default' => 1, 'md' => 2])->schema([
                        Select::make('status')->label('Status')->default('draft')->required()->options([
                            'draft' => 'Rascunho',
                            'published' => 'Publicado',
                            'archived' => 'Arquivado',
                        ]),
                        DateTimePicker::make('published_at')->label('Publicado em')->native(false),
                        TagsInput::make('tags')->label('Tags')->columnSpanFull(),
                    ]),
                ]),
            ])->persistTabInQueryString()->columnSpanFull(),
        ]);
    }
}
