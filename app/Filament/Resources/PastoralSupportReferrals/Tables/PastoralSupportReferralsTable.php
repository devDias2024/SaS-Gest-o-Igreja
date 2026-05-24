<?php

namespace App\Filament\Resources\PastoralSupportReferrals\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PastoralSupportReferralsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('case.title')->label('Prontuario')->searchable(),
                TextColumn::make('type')->label('Tipo')->badge()->sortable(),
                TextColumn::make('provider_name')->label('Rede de apoio')->searchable(),
                TextColumn::make('contact')->label('Contato')->toggleable(),
                TextColumn::make('status')->label('Status')->badge()->sortable(),
                TextColumn::make('referred_at')->label('Encaminhado')->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')->label('Tipo')->options([
                    'psychologist' => 'Psicologo',
                    'psychiatrist' => 'Psiquiatra',
                    'social_assistance' => 'Assistencia social',
                    'legal' => 'Apoio juridico',
                    'other' => 'Outro',
                ]),
                SelectFilter::make('status')->label('Status')->options([
                    'suggested' => 'Sugerido',
                    'accepted' => 'Aceito',
                    'scheduled' => 'Agendado',
                    'declined' => 'Recusado',
                    'completed' => 'Concluido',
                ]),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
