<?php

namespace App\Filament\Resources\CommunicationProviders\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class CommunicationProviderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Provedor')
                    ->tabs([
                        Tab::make('Dados')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        TextInput::make('name')->label('Nome')->required()->maxLength(255),
                                        Select::make('channel')->label('Canal')->required()->options([
                                            'email' => 'E-mail',
                                            'sms' => 'SMS',
                                            'whatsapp' => 'WhatsApp',
                                            'push' => 'Push/App',
                                        ]),
                                        Select::make('driver')->label('Integracao')->default('manual')->required()->options([
                                            'manual' => 'Manual',
                                            'smtp' => 'SMTP',
                                            'twilio' => 'Twilio',
                                            'evolution_api' => 'Evolution API',
                                            'whatsapp_official' => 'WhatsApp Oficial',
                                            'custom_webhook' => 'Webhook customizado',
                                        ])->helperText('SMTP usa a configuracao MAIL_* do sistema. APIs usam as chaves na aba Configuracoes.'),
                                        Toggle::make('is_active')->label('Ativo')->default(true),
                                    ]),
                            ]),
                        Tab::make('Remetente')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        TextInput::make('sender_name')->label('Nome do remetente')->maxLength(255),
                                        TextInput::make('sender_address')->label('Endereco/remetente')->maxLength(255),
                                        TextInput::make('api_base_url')->label('URL da API')->url()->maxLength(255)->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('Configuracoes')
                            ->schema([
                                KeyValue::make('settings')
                                    ->label('Configuracoes da API')
                                    ->helperText('Twilio: account_sid, auth_token. Evolution: instance, api_key. WhatsApp Oficial: access_token, phone_number_id, graph_version, template_name e language_code. Webhook: bearer_token ou api_key.')
                                    ->keyLabel('Chave')
                                    ->valueLabel('Valor')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
