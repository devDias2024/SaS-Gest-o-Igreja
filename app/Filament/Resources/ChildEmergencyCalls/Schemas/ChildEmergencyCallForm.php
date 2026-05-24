<?php

namespace App\Filament\Resources\ChildEmergencyCalls\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ChildEmergencyCallForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Chamada de emergencia')->tabs([
                Tab::make('Destino')->schema([
                    Section::make('Crianca e responsavel')->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            Select::make('child_profile_id')->label('Crianca')->relationship('child', 'full_name')->searchable()->preload()->required(),
                            Select::make('child_check_in_id')->label('Check-in')->relationship('checkIn', 'check_in_code')->searchable()->preload(),
                            Select::make('child_guardian_id')->label('Responsavel')->relationship('guardian', 'name')->searchable()->preload(),
                            TextInput::make('recipient_phone')->label('Telefone destino')->maxLength(255),
                        ]),
                    ]),
                ]),
                Tab::make('Mensagem')->schema([
                    Section::make('Envio')->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            Select::make('channel')->label('Canal')->default('sms')->required()->options([
                                'sms' => 'SMS',
                                'whatsapp' => 'WhatsApp',
                                'app' => 'App',
                                'phone' => 'Ligacao',
                            ]),
                            Select::make('status')->label('Status')->default('pending')->required()->options([
                                'pending' => 'Pendente',
                                'sent' => 'Enviada',
                                'acknowledged' => 'Confirmada',
                                'failed' => 'Falhou',
                            ]),
                            Textarea::make('message')->label('Mensagem')->required()->rows(5)->columnSpanFull(),
                        ]),
                    ]),
                ]),
                Tab::make('Historico')->schema([
                    Section::make('Datas')->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            DateTimePicker::make('sent_at')->label('Enviada em')->native(false),
                            DateTimePicker::make('acknowledged_at')->label('Confirmada em')->native(false),
                        ]),
                    ]),
                ]),
            ])->persistTabInQueryString()->columnSpanFull(),
        ]);
    }
}
