<?php

namespace App\Filament\Resources\PrayerRequests\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class PrayerRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(['default' => 1, 'md' => 2])->schema([
                TextInput::make('name')->label('Pessoa')->required()->maxLength(255),
                TextInput::make('phone')->label('Telefone/WhatsApp')->maxLength(255),
                TextInput::make('email')->label('E-mail')->email()->maxLength(255),
                Select::make('status')->label('Status')->default('new')->required()->options([
                    'new' => 'Novo',
                    'in_progress' => 'Em oracao',
                    'responded' => 'Acompanhado',
                    'closed' => 'Concluido',
                ]),
                DateTimePicker::make('responded_at')->label('Acompanhado em')->native(false),
                Textarea::make('message')
                    ->label('Pedido')
                    ->required()
                    ->rows(7)
                    ->columnSpanFull(),
                TextInput::make('subject')->hidden()->default('Pedido de oracao pelo site'),
                TextInput::make('source')->hidden()->default('prayer'),
            ]),
        ]);
    }
}
