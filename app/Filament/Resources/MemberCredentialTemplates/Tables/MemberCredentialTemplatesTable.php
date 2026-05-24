<?php

namespace App\Filament\Resources\MemberCredentialTemplates\Tables;

use App\Filament\Resources\MemberCredentials\MemberCredentialResource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MemberCredentialTemplatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Modelo')->searchable()->sortable(),
                TextColumn::make('church_name')->label('Igreja')->toggleable(),
                ColorColumn::make('background_color')->label('Fundo'),
                TextColumn::make('default_validity_months')->label('Validade')->suffix(' meses'),
                TextColumn::make('credentials_count')->label('Emitidas')->counts('credentials')->sortable(),
                IconColumn::make('is_active')->label('Ativo')->boolean(),
            ])
            ->recordActions([
                Action::make('issue')
                    ->label('Emitir')
                    ->icon('heroicon-o-identification')
                    ->url(fn ($record): string => MemberCredentialResource::getUrl('create', ['template_id' => $record->id])),
                Action::make('preview')
                    ->label('Previa visual')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record): string => route('credentials.templates.preview', $record))
                    ->openUrlInNewTab(),
                EditAction::make(),
            ])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
