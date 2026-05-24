<?php

namespace App\Filament\Resources\MemberCredentials\Pages;

use App\Filament\Resources\MemberCredentials\MemberCredentialResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMemberCredential extends EditRecord
{
    protected static string $resource = MemberCredentialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('print')
                ->label('Imprimir/PDF')
                ->icon('heroicon-o-printer')
                ->url(fn (): string => route('credentials.print', $this->record))
                ->openUrlInNewTab(),
            DeleteAction::make(),
        ];
    }
}
