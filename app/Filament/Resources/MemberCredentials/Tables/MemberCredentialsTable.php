<?php

namespace App\Filament\Resources\MemberCredentials\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MemberCredentialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->label('Codigo')->searchable()->copyable()->sortable(),
                TextColumn::make('member.full_name')->label('Membro')->searchable()->sortable(),
                TextColumn::make('title')->label('Titulo')->searchable(),
                TextColumn::make('template.name')->label('Modelo')->toggleable(),
                TextColumn::make('issued_on')->label('Emissao')->date('d/m/Y')->sortable(),
                TextColumn::make('expires_on')->label('Validade')->date('d/m/Y')->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'active' => 'Ativa',
                        'expired' => 'Expirada',
                        'revoked' => 'Revogada',
                        default => 'Nao informado',
                    }),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'active' => 'Ativa',
                    'expired' => 'Expirada',
                    'revoked' => 'Revogada',
                ]),
                SelectFilter::make('member_credential_template_id')->label('Modelo')->relationship('template', 'name')->preload(),
            ])
            ->recordActions([
                Action::make('print')
                    ->label('Imprimir/PDF')
                    ->icon('heroicon-o-printer')
                    ->url(fn ($record): string => route('credentials.print', $record))
                    ->openUrlInNewTab(),
                Action::make('validate')
                    ->label('Validar QR')
                    ->icon('heroicon-o-qr-code')
                    ->url(fn ($record): string => route('credentials.validate', $record->validation_token))
                    ->openUrlInNewTab(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}
