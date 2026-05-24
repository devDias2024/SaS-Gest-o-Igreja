<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\ChurchCalendar;
use App\Filament\Widgets\ChurchDashboardOverview;
use App\Filament\Widgets\CashFlowChart;
use App\Filament\Widgets\DashboardQuickActions;
use App\Filament\Widgets\MemberHighlights;
use App\Models\PanelSetting;
use App\Services\PanelModuleRegistry;
use App\Services\PanelPermissionService;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Relaticle\CustomFields\CustomFieldsPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $settings = PanelSetting::current();
        $logo = $settings->panel_logo ? Storage::disk('public')->url($settings->panel_logo) : null;
        $darkLogo = $settings->panel_logo_dark ? Storage::disk('public')->url($settings->panel_logo_dark) : $logo;
        $favicon = $settings->favicon ? Storage::disk('public')->url($settings->favicon) : null;
        $themeMode = ThemeMode::tryFrom($settings->theme_mode ?: 'dark') ?? ThemeMode::Dark;

        $panel = $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName($settings->panel_name ?: config('app.name'))
            ->brandLogo($logo)
            ->darkModeBrandLogo($darkLogo)
            ->brandLogoHeight('2rem')
            ->favicon($favicon)
            ->font($settings->font_family ?: 'Instrument Sans')
            ->darkMode($settings->allow_dark_mode ?? true)
            ->defaultThemeMode($themeMode)
            ->sidebarWidth($settings->sidebar_width ?: '20rem')
            ->sidebarCollapsibleOnDesktop($settings->collapsible_sidebar ?? false)
            ->collapsibleNavigationGroups($settings->collapsible_groups ?? true)
            ->topNavigation($settings->top_navigation ?? false)
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->colors([
                'primary' => $settings->primary_color ?: Color::Amber,
            ])
            ->renderHook(
                PanelsRenderHook::STYLES_AFTER,
                fn (): View => view('filament.panel-style-settings', ['settings' => $settings]),
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->plugins([
                CustomFieldsPlugin::make()
                    ->authorize(fn (): bool => app(PanelPermissionService::class)->allows(
                        auth()->user(),
                        PanelModuleRegistry::SETTINGS_LABEL,
                        'update',
                    )),
            ])
            ->navigationGroups([
                NavigationGroup::make('Gestao de Membros')
                    ->icon(Heroicon::OutlinedUsers),
                NavigationGroup::make('API & Webhooks')
                    ->icon(Heroicon::OutlinedBolt),
                NavigationGroup::make('Patrimonio & Estoque')
                    ->icon(Heroicon::OutlinedArchiveBox),
                NavigationGroup::make('Criancas & Seguranca')
                    ->icon(Heroicon::OutlinedShieldCheck),
                NavigationGroup::make('Eventos & Cultos')
                    ->icon(Heroicon::OutlinedCalendarDays),
                NavigationGroup::make('Comunicacao')
                    ->icon(Heroicon::OutlinedChatBubbleLeftRight),
                NavigationGroup::make('Refeitorio & Despensa')
                    ->icon(Heroicon::OutlinedCake),
                NavigationGroup::make('Financeiro')
                    ->icon(Heroicon::OutlinedBanknotes),
                NavigationGroup::make('Ministerios & Celulas')
                    ->icon(Heroicon::OutlinedUserGroup),
                NavigationGroup::make('Aconselhamento Pastoral')
                    ->icon(Heroicon::OutlinedHeart),
                NavigationGroup::make('Formularios & Registros')
                    ->icon(Heroicon::OutlinedClipboardDocumentList),
                NavigationGroup::make('Biblioteca de Cultos')
                    ->icon(Heroicon::OutlinedPlayCircle),
                NavigationGroup::make('Site Publico')
                    ->icon(Heroicon::OutlinedGlobeAlt),
                NavigationGroup::make('Escola Dominical')
                    ->icon(Heroicon::OutlinedAcademicCap),
                NavigationGroup::make(PanelModuleRegistry::SETTINGS_LABEL)
                    ->icon(Heroicon::OutlinedCog6Tooth),
            ])
            ->widgets([
                ChurchDashboardOverview::class,
                DashboardQuickActions::class,
                MemberHighlights::class,
                CashFlowChart::class,
                ChurchCalendar::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);

        return $panel;
    }
}
