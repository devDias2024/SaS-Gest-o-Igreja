<?php

namespace App\Filament\Resources\PanelUsers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PanelUserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Acesso administrativo')
                ->schema([
                    Grid::make(['default' => 1, 'md' => 2])->schema([
                        TextInput::make('name')->label('Nome')->required()->maxLength(255),
                        TextInput::make('email')->label('E-mail')->email()->required()->unique(ignoreRecord: true)->maxLength(255),
                        TextInput::make('password')
                            ->label('Senha')
                            ->password()
                            ->revealable()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->minLength(8),
                        Select::make('panel_role_id')
                            ->label('Perfil de acesso')
                            ->relationship('panelRole', 'name')
                            ->searchable()
                            ->preload(),
                        Toggle::make('can_access_panel')->label('Pode acessar o painel')->default(true),
                        Toggle::make('is_super_admin')->label('Administrador total')->default(false),
                    ]),
                ]),
        ]);
    }
}
