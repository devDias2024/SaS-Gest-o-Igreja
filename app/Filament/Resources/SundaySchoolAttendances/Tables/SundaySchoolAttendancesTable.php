<?php

namespace App\Filament\Resources\SundaySchoolAttendances\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SundaySchoolAttendancesTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('lesson_date')->label('Data')->date('d/m/Y')->sortable(),
            TextColumn::make('enrollment.member.full_name')->label('Aluno')->searchable(),
            TextColumn::make('enrollment.class.name')->label('Classe')->searchable(),
            TextColumn::make('lesson_title')->label('Licao')->searchable(),
            TextColumn::make('status')->label('Status')->badge()->sortable(),
        ])->filters([
            SelectFilter::make('status')->label('Status')->options(['present' => 'Presente', 'absent' => 'Ausente', 'justified' => 'Justificada']),
            SelectFilter::make('sunday_school_enrollment_id')->label('Aluno')->relationship('enrollment.member', 'full_name')->searchable()->preload(),
        ])->recordActions([EditAction::make()])->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])->defaultSort('lesson_date', 'desc');
    }
}
