<?php

namespace App\Filament\Resources\WebhookDeliveries\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WebhookDeliveriesTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('created_at')->label('Data')->dateTime('d/m/Y H:i:s')->sortable(),
            TextColumn::make('endpoint.name')->label('Endpoint')->searchable(),
            TextColumn::make('event_name')->label('Evento')->badge()->searchable(),
            TextColumn::make('status')->label('Status')->badge()->sortable(),
            TextColumn::make('status_code')->label('HTTP')->sortable(),
            TextColumn::make('error_message')->label('Erro')->limit(60)->toggleable(),
        ])->filters([
            SelectFilter::make('event_name')->label('Evento')->options([
                'member.created' => 'member.created',
                'tithe.received' => 'tithe.received',
                'event.checkin' => 'event.checkin',
                'form.submitted' => 'form.submitted',
                'counseling.session_scheduled' => 'counseling.session_scheduled',
            ]),
            SelectFilter::make('status')->label('Status')->options([
                'pending' => 'Pendente',
                'delivered' => 'Entregue',
                'failed' => 'Falhou',
            ]),
        ])->defaultSort('created_at', 'desc');
    }
}
