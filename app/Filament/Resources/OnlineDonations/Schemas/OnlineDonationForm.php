<?php

namespace App\Filament\Resources\OnlineDonations\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;

class OnlineDonationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Doacao online')
                    ->tabs([
                        Tab::make('Doador')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        Select::make('member_id')->label('Membro')->relationship('member', 'full_name')->searchable()->preload(),
                                        Toggle::make('is_anonymous')->label('Anonima')->inline(false),
                                        TextInput::make('donor_name')->label('Nome do doador')->maxLength(255),
                                        TextInput::make('donor_email')->label('E-mail')->email()->maxLength(255),
                                        PhoneNumber::make('donor_phone')->label('Telefone')->maxLength(255),
                                        TextInput::make('amount')->label('Valor')->numeric()->prefix('R$')->required(),
                                        Select::make('fund_id')->label('Fundo')->relationship('fund', 'name')->searchable()->preload(),
                                    ]),
                            ]),
                        Tab::make('Pagamento')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        TextInput::make('payment_gateway')->label('Gateway')->maxLength(255),
                                        TextInput::make('gateway_reference')->label('Referencia gateway')->maxLength(255),
                                        Select::make('payment_method')->label('Forma de pagamento')->options([
                                            'pix' => 'Pix',
                                            'card' => 'Cartao',
                                            'boleto' => 'Boleto',
                                        ]),
                                        Select::make('status')->label('Status')->default('pending')->required()->options([
                                            'pending' => 'Pendente',
                                            'paid' => 'Paga',
                                            'failed' => 'Falhou',
                                            'refunded' => 'Estornada',
                                        ]),
                                        Select::make('financial_transaction_id')->label('Lancamento gerado')->relationship('transaction', 'description')->searchable(),
                                        DateTimePicker::make('paid_at')->label('Pago em')->native(false),
                                        DateTimePicker::make('receipt_sent_at')->label('Recibo enviado em')->native(false),
                                    ]),
                            ]),
                        Tab::make('Webhook')
                            ->schema([
                                Textarea::make('payload')
                                    ->label('Payload/webhook')
                                    ->rows(8)
                                    ->dehydrated(false)
                                    ->formatStateUsing(fn ($state): ?string => $state ? json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : null)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
