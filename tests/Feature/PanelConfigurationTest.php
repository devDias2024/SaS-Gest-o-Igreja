<?php

use App\Filament\Resources\Assets\AssetResource;
use App\Filament\Resources\Members\MemberResource;
use App\Filament\Resources\PanelRoles\PanelRoleResource;
use App\Filament\Resources\PanelSettings\PanelSettingResource;
use App\Filament\Resources\PanelUsers\PanelUserResource;
use App\Filament\Resources\PrayerRequests\PrayerRequestResource;
use App\Filament\Widgets\ChurchCalendar;
use App\Filament\Widgets\ChurchDashboardOverview;
use App\Filament\Widgets\CashFlowChart;
use App\Filament\Widgets\DashboardQuickActions;
use App\Filament\Widgets\MemberHighlights;
use App\Models\PanelRole;
use App\Models\PanelSetting;
use App\Models\Member;
use App\Models\PublicContact;
use App\Models\User;
use App\Providers\Filament\AdminPanelProvider;
use Filament\Panel;
use Livewire\Livewire;
use Relaticle\CustomFields\Models\Contracts\HasCustomFields;

it('applies panel identity settings to the admin panel', function () {
    PanelSetting::query()->firstOrFail()->update([
        'panel_name' => 'Ministerio Vida',
        'primary_color' => '#16a34a',
        'font_family' => 'Poppins',
        'theme_mode' => 'light',
    ]);

    $panel = (new AdminPanelProvider(app()))->panel(Panel::make());

    expect($panel->getBrandName())->toBe('Ministerio Vida')
        ->and($panel->getFontFamily())->toBe('Poppins');
});

it('limits panel modules using the assigned access profile', function () {
    $role = PanelRole::create([
        'name' => 'Secretaria',
        'is_active' => true,
        'permissions' => [
            'gestao_membros' => ['view'],
        ],
    ]);
    $user = User::factory()->create([
        'panel_role_id' => $role->id,
        'is_super_admin' => false,
        'can_access_panel' => true,
    ]);

    $this->actingAs($user);

    expect(MemberResource::canViewAny())->toBeTrue()
        ->and(MemberResource::canCreate())->toBeFalse()
        ->and(AssetResource::canViewAny())->toBeFalse()
        ->and(PanelSettingResource::canViewAny())->toBeFalse()
        ->and(MemberHighlights::canView())->toBeTrue()
        ->and(ChurchCalendar::canView())->toBeFalse()
        ->and(ChurchDashboardOverview::canView())->toBeTrue()
        ->and(DashboardQuickActions::canView())->toBeFalse();
});

it('keeps full panel access for super administrators', function () {
    $user = User::factory()->create([
        'is_super_admin' => true,
        'can_access_panel' => true,
    ]);

    $this->actingAs($user);

    expect(PanelSettingResource::canViewAny())->toBeTrue()
        ->and(MemberResource::canCreate())->toBeTrue()
        ->and(ChurchDashboardOverview::canView())->toBeTrue();

    $this->actingAs($user)
        ->get('/admin')
        ->assertOk();

    Livewire::test(DashboardQuickActions::class)
        ->assertSee('Novo membro')
        ->assertSee('Pedido de oracao');

    Livewire::test(CashFlowChart::class)
        ->assertSee('Fluxo de caixa mensal');
});

it('renders the administration configuration screens for a super administrator', function () {
    $user = User::factory()->create([
        'is_super_admin' => true,
        'can_access_panel' => true,
    ]);

    $this->actingAs($user)
        ->get(PanelSettingResource::getUrl('edit', ['record' => PanelSetting::query()->firstOrFail()]))
        ->assertOk()
        ->assertSee('Nome do painel');

    $this->actingAs($user)
        ->get(PanelRoleResource::getUrl('create'))
        ->assertOk()
        ->assertSee('Permissoes por modulo');

    $this->actingAs($user)
        ->get(PanelUserResource::getUrl('create'))
        ->assertOk()
        ->assertSee('Acesso administrativo');
});

it('integrates custom fields into members and protects field management', function () {
    $administrator = User::factory()->create([
        'is_super_admin' => true,
        'can_access_panel' => true,
    ]);

    expect(new Member)->toBeInstanceOf(HasCustomFields::class);

    $this->actingAs($administrator)
        ->get(MemberResource::getUrl('create'))
        ->assertOk()
        ->assertSee('Campos personalizados');

    $this->actingAs($administrator)
        ->get(route('filament.admin.pages.custom-fields'))
        ->assertOk();

    $role = PanelRole::create([
        'name' => 'Secretaria sem configuracao',
        'is_active' => true,
        'permissions' => [
            'gestao_membros' => ['view'],
        ],
    ]);
    $assistant = User::factory()->create([
        'panel_role_id' => $role->id,
        'is_super_admin' => false,
        'can_access_panel' => true,
    ]);

    $this->actingAs($assistant)
        ->get(route('filament.admin.pages.custom-fields'))
        ->assertForbidden();
});

it('routes public prayer requests to pastoral care without mixing regular contacts', function () {
    $this->post(route('public.contacts.store'), [
        'contact_type' => 'prayer',
        'name' => 'Maria Oliveira',
        'phone' => '(11) 99999-1111',
        'subject' => 'Pedido de oracao pelo site',
        'message' => 'Oracao pela minha familia.',
    ])->assertSessionHas('status');

    $request = PublicContact::query()->firstOrFail();

    expect($request->source)->toBe('prayer')
        ->and(PrayerRequestResource::getEloquentQuery()->count())->toBe(1)
        ->and(\App\Filament\Resources\PublicContacts\PublicContactResource::getEloquentQuery()->count())->toBe(0);

    $administrator = User::factory()->create([
        'is_super_admin' => true,
        'can_access_panel' => true,
    ]);

    $this->actingAs($administrator)
        ->get(PrayerRequestResource::getUrl())
        ->assertOk()
        ->assertSee('Maria Oliveira');
});
