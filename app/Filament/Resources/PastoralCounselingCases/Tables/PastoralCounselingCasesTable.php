<?php

namespace App\Filament\Resources\PastoralCounselingCases\Tables;

use App\Models\PastoralEmergencyAlert;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PastoralCounselingCasesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Prontuario')->searchable()->sortable(),
                TextColumn::make('member.full_name')->label('Aconselhado')->searchable(),
                TextColumn::make('primaryPastor.name')->label('Pastor')->searchable(),
                TextColumn::make('main_subject')->label('Assunto')->searchable()->toggleable(),
                TextColumn::make('privacy_level')->label('Sigilo')->badge(),
                TextColumn::make('status')->label('Status')->badge()->sortable(),
                TextColumn::make('opened_at')->label('Aberto')->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'open' => 'Aberto',
                    'in_follow_up' => 'Em acompanhamento',
                    'referred' => 'Encaminhado',
                    'closed' => 'Encerrado',
                ]),
                SelectFilter::make('privacy_level')->label('Sigilo')->options([
                    'confidential' => 'Sigiloso',
                    'restricted' => 'Restrito',
                    'critical' => 'Critico',
                ]),
            ])
            ->recordActions([
                Action::make('emergency')
                    ->label('Emergencia')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn ($record) => PastoralEmergencyAlert::query()->create([
                        'pastoral_counseling_case_id' => $record->id,
                        'triggered_by_user_id' => auth()->id(),
                        'contact_phone' => $record->emergency_contact_phone,
                        'message' => 'Emergencia pastoral acionada para '.$record->title,
                        'status' => 'open',
                        'triggered_at' => now(),
                    ])),
                EditAction::make(),
            ])
            ->headerActions([
                Action::make('demand_report')
                    ->label('Relatorio de demanda')
                    ->url(route('pastoral-counseling.reports.demand'))
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('opened_at', 'desc');
    }
}
