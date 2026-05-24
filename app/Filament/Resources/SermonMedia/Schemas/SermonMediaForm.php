<?php

namespace App\Filament\Resources\SermonMedia\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class SermonMediaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Midia')->tabs([
                Tab::make('Arquivo ou embed')->schema([
                    Grid::make(['default' => 1, 'md' => 2])->schema([
                        Select::make('sermon_id')->label('Pregacao')->relationship('sermon', 'title')->searchable()->preload()->required()->columnSpanFull(),
                        TextInput::make('title')->label('Titulo da midia')->maxLength(255),
                        Select::make('media_type')->label('Tipo')->default('audio')->required()->options([
                            'audio' => 'Audio',
                            'video' => 'Video',
                            'live' => 'Ao vivo',
                        ]),
                        Select::make('source')->label('Origem')->default('upload')->live()->required()->options([
                            'upload' => 'Upload',
                            'youtube' => 'YouTube',
                            'livepeer' => 'Livepeer',
                            'external' => 'URL externa',
                        ]),
                        Select::make('disk')->label('Armazenamento')->default('public')->options([
                            'public' => 'Publico local',
                            's3' => 'S3',
                        ])->visible(fn (Get $get): bool => $get('source') === 'upload'),
                        FileUpload::make('file_path')
                            ->label('Arquivo')
                            ->disk(fn (Get $get): string => $get('disk') ?: 'public')
                            ->directory('sermons')
                            ->acceptedFileTypes(['audio/mpeg', 'audio/mp4', 'audio/wav', 'video/mp4', 'video/webm', 'video/quicktime'])
                            ->visible(fn (Get $get): bool => $get('source') === 'upload')
                            ->columnSpanFull(),
                        TextInput::make('external_url')->label('URL publica')->url()->visible(fn (Get $get): bool => $get('source') !== 'upload')->columnSpanFull(),
                        TextInput::make('embed_url')->label('URL de embed')->url()->visible(fn (Get $get): bool => in_array($get('source'), ['youtube', 'livepeer', 'external'], true))->columnSpanFull(),
                    ]),
                ]),
                Tab::make('Reproducao')->schema([
                    Grid::make(['default' => 1, 'md' => 2])->schema([
                        TextInput::make('duration_seconds')->label('Duracao em segundos')->numeric()->integer(),
                        TextInput::make('file_size')->label('Tamanho em bytes')->numeric()->integer(),
                        Toggle::make('is_primary')->label('Midia principal')->default(true),
                        Toggle::make('allow_download')->label('Permitir download')->default(false),
                    ]),
                ]),
            ])->persistTabInQueryString()->columnSpanFull(),
        ]);
    }
}
