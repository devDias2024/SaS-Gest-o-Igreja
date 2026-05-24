<?php

namespace App\Filament\Resources\MemberCredentials\Schemas;

use App\Models\MemberCredentialTemplate;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class MemberCredentialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Credencial do membro')
                ->tabs([
                    Tab::make('Emissao')
                        ->schema([
                            Grid::make(['default' => 1, 'md' => 2])->schema([
                                Select::make('member_id')
                                    ->label('Membro')
                                    ->relationship('member', 'full_name')
                                    ->default(fn (): ?int => request()->integer('member_id') ?: null)
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Select::make('member_credential_template_id')
                                    ->label('Modelo visual')
                                    ->relationship('template', 'name')
                                    ->default(fn (): ?int => request()->integer('template_id') ?: MemberCredentialTemplate::query()->where('is_active', true)->value('id'))
                                    ->searchable()
                                    ->preload(),
                                TextInput::make('title')->label('Titulo na credencial')->default('Membro')->required()->maxLength(255),
                                Select::make('blood_type')->label('Tipo sanguineo')->options([
                                    'A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-',
                                    'AB+' => 'AB+', 'AB-' => 'AB-', 'O+' => 'O+', 'O-' => 'O-',
                                ]),
                                DatePicker::make('issued_on')->label('Emissao')->default(today())->native(false)->required(),
                                DatePicker::make('expires_on')->label('Validade')->native(false),
                                Select::make('status')->label('Status')->default('active')->required()->options([
                                    'active' => 'Ativa',
                                    'expired' => 'Expirada',
                                    'revoked' => 'Revogada',
                                ]),
                                Toggle::make('issuance_registered')->label('Registrar emissao')->default(true),
                            ]),
                        ]),
                    Tab::make('Identificacao')
                        ->schema([
                            Fieldset::make('Gerados automaticamente')->schema([
                                TextInput::make('code')->label('Codigo')->disabled()->dehydrated(false),
                                TextInput::make('validation_token')->label('Token do QR Code')->disabled()->dehydrated(false),
                            ])->columns(['default' => 1, 'md' => 2]),
                            Textarea::make('notes')->label('Observacoes')->rows(4)->columnSpanFull(),
                        ]),
                ])
                ->persistTabInQueryString()
                ->columnSpanFull(),
        ]);
    }
}
