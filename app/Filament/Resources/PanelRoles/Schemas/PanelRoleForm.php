<?php

namespace App\Filament\Resources\PanelRoles\Schemas;

use App\Services\PanelModuleRegistry;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PanelRoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Perfil')
                ->schema([
                    Grid::make(['default' => 1, 'md' => 2])->schema([
                        TextInput::make('name')->label('Nome')->required()->maxLength(255),
                        Toggle::make('is_active')->label('Ativo')->default(true),
                        Textarea::make('description')->label('Descricao')->rows(2)->columnSpanFull(),
                    ]),
                ]),
            Section::make('Permissoes por modulo')
                ->schema(
                    collect(PanelModuleRegistry::modules())
                        ->map(fn (string $label, string $key): CheckboxList => CheckboxList::make("permissions.{$key}")
                            ->label($label)
                            ->options(PanelModuleRegistry::actions())
                            ->columns(2)
                            ->gridDirection('row')
                            ->bulkToggleable())
                        ->values()
                        ->all()
                )
                ->columns(['default' => 1, 'md' => 2])
                ->columnSpanFull(),
        ]);
    }
}
