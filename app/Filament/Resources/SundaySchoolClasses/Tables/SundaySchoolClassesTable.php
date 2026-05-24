<?php

namespace App\Filament\Resources\SundaySchoolClasses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SundaySchoolClassesTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->label('Classe')->searchable()->sortable(),
            TextColumn::make('course_name')->label('Curso')->searchable(),
            TextColumn::make('teacher.full_name')->label('Professor')->searchable(),
            TextColumn::make('period_label')->label('Periodo')->sortable(),
            TextColumn::make('enrollments_count')->label('Matriculas')->counts('enrollments'),
            TextColumn::make('status')->label('Status')->badge()->sortable(),
        ])->filters([
            SelectFilter::make('status')->label('Status')->options(['active' => 'Ativa', 'completed' => 'Concluida', 'paused' => 'Pausada', 'archived' => 'Arquivada']),
        ])->recordActions([EditAction::make()])->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
