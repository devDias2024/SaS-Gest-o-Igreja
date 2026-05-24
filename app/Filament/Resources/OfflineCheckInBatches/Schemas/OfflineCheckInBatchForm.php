<?php

namespace App\Filament\Resources\OfflineCheckInBatches\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class OfflineCheckInBatchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Sincronizacao offline')
                    ->tabs([
                        Tab::make('Resumo')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        Select::make('church_event_id')->label('Evento')->relationship('event', 'title')->searchable()->preload(),
                                        TextInput::make('device_id')->label('Dispositivo')->maxLength(255),
                                        TextInput::make('uploaded_by')->label('Enviado por')->maxLength(255),
                                        TextInput::make('records_count')->label('Registros')->numeric()->default(0),
                                        TextInput::make('processed_count')->label('Processados')->numeric()->default(0),
                                        TextInput::make('failed_count')->label('Falhas')->numeric()->default(0),
                                        Select::make('status')->label('Status')->default('pending')->required()->options([
                                            'pending' => 'Pendente',
                                            'processed' => 'Processado',
                                            'processed_with_errors' => 'Processado com erros',
                                            'failed' => 'Falhou',
                                        ]),
                                        DateTimePicker::make('processed_at')->label('Processado em')->native(false),
                                    ]),
                            ]),
                        Tab::make('Dados')
                            ->schema([
                                Textarea::make('payload')
                                    ->label('Payload')
                                    ->rows(8)
                                    ->formatStateUsing(fn ($state): ?string => $state ? json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : null)
                                    ->dehydrated(false)
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('Erros')
                            ->schema([
                                Textarea::make('error_message')->label('Erro')->rows(6)->columnSpanFull(),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
