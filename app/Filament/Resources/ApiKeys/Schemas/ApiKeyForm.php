<?php

namespace App\Filament\Resources\ApiKeys\Schemas;

use App\Models\ApiKey;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ApiKeyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Acesso externo')->schema([
                Grid::make(['default' => 1, 'md' => 2])->schema([
                    TextInput::make('name')->label('Nome')->required()->maxLength(255),
                    TextInput::make('plain_token')->label('Token da API')->password()->revealable()->default(fn (?ApiKey $record = null) => $record ? null : ApiKey::generateToken())->helperText('Ao criar, copie esta chave antes de salvar. Ao editar, preencha somente para trocar o token.'),
                    TagsInput::make('scopes')->label('Escopos')->placeholder('members.read'),
                    TagsInput::make('allowed_ips')->label('IPs permitidos')->placeholder('127.0.0.1'),
                    TextInput::make('rate_limit_per_minute')->label('Limite por minuto')->numeric()->default(60)->required(),
                    DateTimePicker::make('expires_at')->label('Expira em')->native(false),
                    Toggle::make('is_active')->label('Ativa')->default(true),
                ]),
            ])->columnSpanFull(),
        ]);
    }
}
