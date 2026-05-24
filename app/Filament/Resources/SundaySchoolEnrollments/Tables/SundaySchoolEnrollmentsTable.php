<?php

namespace App\Filament\Resources\SundaySchoolEnrollments\Tables;

use App\Models\SundaySchoolCertificate;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SundaySchoolEnrollmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('member.full_name')->label('Aluno')->searchable()->sortable(),
            TextColumn::make('class.name')->label('Classe')->searchable(),
            TextColumn::make('class.period_label')->label('Periodo')->toggleable(),
            TextColumn::make('attendance_percent')->label('Freq.')->suffix('%')->sortable(),
            TextColumn::make('final_grade')->label('Media')->sortable(),
            TextColumn::make('status')->label('Status')->badge()->sortable(),
            TextColumn::make('completed_on')->label('Conclusao')->date('d/m/Y')->toggleable(),
        ])->filters([
            SelectFilter::make('sunday_school_class_id')->label('Classe')->relationship('class', 'name')->searchable()->preload(),
            SelectFilter::make('member_id')->label('Membro')->relationship('member', 'full_name')->searchable()->preload(),
            SelectFilter::make('status')->label('Status')->options(['active' => 'Ativa', 'completed' => 'Concluida', 'approved' => 'Aprovado', 'failed' => 'Reprovado', 'dropped' => 'Desistente']),
        ])->recordActions([
            Action::make('recalculate')->label('Recalcular')->action(fn ($record) => $record->refreshAcademicTotals()),
            Action::make('certificate')->label('Emitir certificado')->visible(fn ($record) => ! $record->certificate)->action(fn ($record) => SundaySchoolCertificate::query()->create(['sunday_school_enrollment_id' => $record->id, 'signer_name' => config('app.name'), 'signer_title' => 'Direcao da Escola Dominical'])),
            Action::make('history')->label('Historico')->url(fn ($record) => route('sunday-school.members.history', $record->member))->openUrlInNewTab(),
            EditAction::make(),
        ])->headerActions([
            Action::make('approval_report')->label('Relatorio aprovacao')->url(route('sunday-school.reports.approvals'))->openUrlInNewTab(),
        ])->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
