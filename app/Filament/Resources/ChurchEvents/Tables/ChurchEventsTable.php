<?php

namespace App\Filament\Resources\ChurchEvents\Tables;

use App\Models\EventVolunteerAssignment;
use App\Models\Member;
use App\Models\VolunteerRole;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ChurchEventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('starts_at')
                    ->label('Data')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Evento')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'service' => 'Culto',
                        'event' => 'Evento',
                        'class' => 'Aula',
                        'meeting' => 'Reuniao',
                        'rehearsal' => 'Ensaio',
                        default => 'Outro',
                    }),
                TextColumn::make('location.name')
                    ->label('Local')
                    ->toggleable(),
                TextColumn::make('confirmed_registrations_count')
                    ->label('Inscritos')
                    ->state(fn ($record): string => $record->effective_capacity
                        ? "{$record->confirmed_registrations_count}/{$record->effective_capacity}"
                        : (string) $record->confirmed_registrations_count),
                TextColumn::make('check_ins_count')
                    ->label('Presencas')
                    ->counts('checkIns')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                IconColumn::make('geofencing_enabled')
                    ->label('Geo')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        'service' => 'Culto',
                        'event' => 'Evento',
                        'class' => 'Aula/curso',
                        'meeting' => 'Reuniao',
                        'rehearsal' => 'Ensaio',
                    ]),
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'scheduled' => 'Agendado',
                        'open' => 'Inscricoes abertas',
                        'finished' => 'Finalizado',
                        'canceled' => 'Cancelado',
                    ]),
                Filter::make('upcoming')
                    ->label('Proximos')
                    ->query(fn (Builder $query): Builder => $query->where('starts_at', '>=', now())),
                Filter::make('this_month')
                    ->label('Mes atual')
                    ->query(fn (Builder $query): Builder => $query
                        ->whereMonth('starts_at', now()->month)
                        ->whereYear('starts_at', now()->year)),
            ])
            ->recordActions([
                Action::make('copyCheckInUrl')
                    ->label('QR Code')
                    ->icon('heroicon-o-qr-code')
                    ->url(fn ($record): string => route('events.check-in.qr', $record->check_in_token))
                    ->openUrlInNewTab(),
                Action::make('newDynamicQr')
                    ->label('Gerar QR dinamico')
                    ->icon('heroicon-o-arrow-path')
                    ->action(fn ($record) => $record->checkInSessions()->create([
                        'token' => Str::random(48),
                        'expires_at' => now()->addMinutes(10),
                        'is_active' => true,
                    ])),
                Action::make('autoAssignVolunteers')
                    ->label('Gerar escala')
                    ->icon('heroicon-o-user-group')
                    ->requiresConfirmation()
                    ->action(function ($record): void {
                        $memberIds = Member::query()
                            ->orderBy('full_name')
                            ->pluck('id')
                            ->all();

                        if ($memberIds === []) {
                            return;
                        }

                        VolunteerRole::query()
                            ->where('is_active', true)
                            ->where('rotates_automatically', true)
                            ->get()
                            ->each(function (VolunteerRole $role) use ($record, $memberIds): void {
                                $assignmentCounts = EventVolunteerAssignment::query()
                                    ->where('volunteer_role_id', $role->id)
                                    ->whereNotNull('member_id')
                                    ->selectRaw('member_id, count(*) as total')
                                    ->groupBy('member_id')
                                    ->pluck('total', 'member_id')
                                    ->all();

                                $alreadyAssigned = $record->volunteerAssignments()
                                    ->where('volunteer_role_id', $role->id)
                                    ->count();

                                for ($slot = $alreadyAssigned + 1; $slot <= $role->default_slots; $slot++) {
                                    $memberId = collect($memberIds)
                                        ->sortBy(fn (int $memberId): int => (int) ($assignmentCounts[$memberId] ?? 0))
                                        ->first();

                                    EventVolunteerAssignment::query()->firstOrCreate([
                                        'church_event_id' => $record->id,
                                        'volunteer_role_id' => $role->id,
                                        'member_id' => $memberId,
                                        'slot_number' => $slot,
                                    ], [
                                        'status' => 'scheduled',
                                        'auto_assigned' => true,
                                    ]);

                                    $assignmentCounts[$memberId] = (int) ($assignmentCounts[$memberId] ?? 0) + 1;
                                }
                            });
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
