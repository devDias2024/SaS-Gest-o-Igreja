<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ChurchEvents\ChurchEventResource;
use App\Filament\Resources\CommunicationMessages\CommunicationMessageResource;
use App\Filament\Resources\FinancialTransactions\FinancialTransactionResource;
use App\Filament\Resources\MemberCredentials\MemberCredentialResource;
use App\Filament\Resources\Members\MemberResource;
use App\Filament\Resources\PrayerRequests\PrayerRequestResource;
use App\Filament\Resources\VisitorRegistrations\VisitorRegistrationResource;
use App\Services\PanelPermissionService;
use Filament\Widgets\Widget;

class DashboardQuickActions extends Widget
{
    protected static ?int $sort = 2;

    protected string $view = 'filament.widgets.dashboard-quick-actions';

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return self::actions() !== [];
    }

    protected function getViewData(): array
    {
        return ['actions' => self::actions()];
    }

    private static function actions(): array
    {
        $permissions = app(PanelPermissionService::class);
        $user = auth()->user();
        $actions = [];

        if ($permissions->allows($user, 'Gestao de Membros', 'create')) {
            $actions[] = ['label' => 'Novo membro', 'icon' => 'heroicon-o-user-plus', 'url' => MemberResource::getUrl('create')];
            $actions[] = ['label' => 'Gerar carteirinha', 'icon' => 'heroicon-o-identification', 'url' => MemberCredentialResource::getUrl('create')];
        }

        if ($permissions->allows($user, 'Site Publico', 'create')) {
            $actions[] = ['label' => 'Novo visitante', 'icon' => 'heroicon-o-user-group', 'url' => VisitorRegistrationResource::getUrl('create')];
        }

        if ($permissions->allows($user, 'Eventos & Cultos', 'create')) {
            $actions[] = ['label' => 'Novo evento', 'icon' => 'heroicon-o-calendar-days', 'url' => ChurchEventResource::getUrl('create')];
        }

        if ($permissions->allows($user, 'Comunicacao', 'create')) {
            $actions[] = ['label' => 'Enviar mensagem', 'icon' => 'heroicon-o-paper-airplane', 'url' => CommunicationMessageResource::getUrl('create')];
        }

        if ($permissions->allows($user, 'Financeiro', 'create')) {
            $actions[] = ['label' => 'Registrar oferta', 'icon' => 'heroicon-o-banknotes', 'url' => FinancialTransactionResource::getUrl('create')];
        }

        if ($permissions->allows($user, 'Aconselhamento Pastoral', 'create')) {
            $actions[] = ['label' => 'Pedido de oracao', 'icon' => 'heroicon-o-heart', 'url' => PrayerRequestResource::getUrl('create')];
        }

        return $actions;
    }
}
