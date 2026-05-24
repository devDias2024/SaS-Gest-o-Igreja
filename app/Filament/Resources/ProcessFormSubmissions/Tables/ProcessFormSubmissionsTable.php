<?php

namespace App\Filament\Resources\ProcessFormSubmissions\Tables;

use App\Models\ProcessFormSubmission;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProcessFormSubmissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('submitted_at')->label('Enviado')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('form.title')->label('Formulario')->searchable()->sortable(),
                TextColumn::make('submitter_name')->label('Nome')->searchable(),
                TextColumn::make('submitter_email')->label('E-mail')->searchable(),
                TextColumn::make('submitter_phone')->label('Telefone')->searchable(),
                TextColumn::make('status')->label('Status')->badge()->sortable(),
            ])
            ->filters([
                SelectFilter::make('process_form_id')->label('Formulario')->relationship('form', 'title')->searchable()->preload(),
                SelectFilter::make('status')->label('Status')->options([
                    'pending' => 'Pendente',
                    'approved' => 'Aprovado',
                    'completed' => 'Concluido',
                    'archived' => 'Arquivado',
                ]),
            ])
            ->recordActions([EditAction::make()])
            ->headerActions([
                Action::make('export_csv')
                    ->label('Exportar CSV')
                    ->action(fn () => self::csvResponse()),
            ])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('submitted_at', 'desc');
    }

    protected static function csvResponse(): StreamedResponse
    {
        return response()->streamDownload(function (): void {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Formulario', 'Nome', 'E-mail', 'Telefone', 'Status', 'Enviado em', 'Respostas']);

            ProcessFormSubmission::query()->with('form')->orderByDesc('submitted_at')->chunk(200, function ($submissions) use ($out): void {
                foreach ($submissions as $submission) {
                    fputcsv($out, [
                        $submission->form?->title,
                        $submission->submitter_name,
                        $submission->submitter_email,
                        $submission->submitter_phone,
                        $submission->status,
                        $submission->submitted_at?->format('d/m/Y H:i'),
                        json_encode($submission->answers, JSON_UNESCAPED_UNICODE),
                    ]);
                }
            });

            fclose($out);
        }, 'respostas-formularios.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
