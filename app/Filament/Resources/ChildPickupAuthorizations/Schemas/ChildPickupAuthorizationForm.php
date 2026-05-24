<?php

namespace App\Filament\Resources\ChildPickupAuthorizations\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ChildPickupAuthorizationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Autorizacao de retirada')->tabs([
                Tab::make('Autorizado')->schema([
                    Section::make('Pessoa autorizada')->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            Select::make('child_profile_id')->label('Crianca')->relationship('child', 'full_name')->searchable()->preload()->required(),
                            Select::make('child_guardian_id')->label('Responsavel que autorizou')->relationship('guardian', 'name')->searchable()->preload(),
                            TextInput::make('authorized_name')->label('Nome autorizado')->required()->maxLength(255),
                            TextInput::make('document_number')->label('Documento')->maxLength(255),
                            TextInput::make('phone')->label('Telefone')->maxLength(255),
                            FileUpload::make('photo')->label('Foto')->image()->disk('public')->directory('children/authorizations'),
                        ]),
                    ]),
                ]),
                Tab::make('Validade')->schema([
                    Section::make('Periodo e status')->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            DateTimePicker::make('valid_from')->label('Valida de')->native(false),
                            DateTimePicker::make('valid_until')->label('Valida ate')->native(false),
                            Select::make('status')->label('Status')->default('active')->required()->options([
                                'active' => 'Ativa',
                                'used' => 'Usada',
                                'expired' => 'Expirada',
                                'revoked' => 'Revogada',
                            ]),
                        ]),
                    ]),
                ]),
                Tab::make('Observacoes')->schema([
                    Section::make('Notas internas')->schema([
                        Textarea::make('notes')->label('Observacoes')->rows(5)->columnSpanFull(),
                    ]),
                ]),
            ])->persistTabInQueryString()->columnSpanFull(),
        ]);
    }
}
