<?php

namespace App\Filament\Resources\SundaySchoolCertificates\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SundaySchoolCertificatesTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('certificate_number')->label('Numero')->searchable()->copyable(),
            TextColumn::make('enrollment.member.full_name')->label('Aluno')->searchable(),
            TextColumn::make('enrollment.class.name')->label('Classe')->searchable(),
            TextColumn::make('issued_on')->label('Emitido')->date('d/m/Y')->sortable(),
            TextColumn::make('status')->label('Status')->badge()->sortable(),
        ])->filters([
            SelectFilter::make('status')->label('Status')->options(['issued' => 'Emitido', 'revoked' => 'Revogado']),
        ])->recordActions([
            Action::make('print')->label('Imprimir/PDF')->url(fn ($record) => route('sunday-school.certificates.print', $record))->openUrlInNewTab(),
            Action::make('validate')->label('Validar')->url(fn ($record) => route('sunday-school.certificates.validate', $record->validation_token))->openUrlInNewTab(),
            EditAction::make(),
        ])->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
