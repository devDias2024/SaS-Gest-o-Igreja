<?php

namespace App\Filament\Resources\SundaySchoolCertificates\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class SundaySchoolCertificateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([Grid::make(['default' => 1, 'md' => 2])->schema([
            Select::make('sunday_school_enrollment_id')->label('Matricula')->relationship('enrollment.member', 'full_name')->searchable()->preload()->required(),
            TextInput::make('certificate_number')->label('Numero')->disabled(),
            TextInput::make('validation_token')->label('Token de validacao')->disabled(),
            DatePicker::make('issued_on')->label('Emitido em')->native(false),
            Select::make('status')->label('Status')->default('issued')->options(['issued' => 'Emitido', 'revoked' => 'Revogado'])->required(),
            TextInput::make('signer_name')->label('Assinante')->maxLength(255),
            TextInput::make('signer_title')->label('Cargo')->maxLength(255),
            Textarea::make('notes')->label('Observacoes')->rows(3)->columnSpanFull(),
        ])->columnSpanFull()]);
    }
}
