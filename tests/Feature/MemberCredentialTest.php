<?php

use App\Models\Member;
use App\Models\MemberCredential;
use App\Models\MemberCredentialTemplate;
use App\Models\User;
use App\Models\WebhookEndpoint;
use Illuminate\Support\Facades\Http;

it('issues and publicly validates a member credential', function () {
    $member = Member::create(['full_name' => 'Maria da Silva']);
    $template = MemberCredentialTemplate::query()->firstOrFail();
    $template->update(['church_logo' => 'credentials/logos/igreja.png']);
    $credential = MemberCredential::create([
        'member_id' => $member->id,
        'member_credential_template_id' => $template->id,
        'title' => 'Membro',
        'expires_on' => now()->addYear()->toDateString(),
        'status' => 'active',
    ]);

    expect($credential->code)->toStartWith('CRD-')
        ->and($credential->validation_token)->not->toBeEmpty()
        ->and($credential->template)->not->toBeNull()
        ->and($credential->expires_on)->not->toBeNull()
        ->and($credential->isValid())->toBeTrue();

    $this->get(route('credentials.validate', $credential->validation_token))
        ->assertOk()
        ->assertSee('Credencial valida')
        ->assertSee('Maria da Silva');

    $this->actingAs(User::factory()->create())
        ->get(route('credentials.print', $credential))
        ->assertOk()
        ->assertSee($credential->code)
        ->assertSee('Medida padrao: 86 mm x 54 mm (8,6 cm x 5,4 cm)')
        ->assertSee('artwork')
        ->assertSee('credentials/logos/igreja.png');
});

it('dispatches a webhook when a credential is issued', function () {
    Http::fake(['https://integracao.test/credenciais' => Http::response(['received' => true])]);

    WebhookEndpoint::create([
        'name' => 'Credenciais',
        'url' => 'https://integracao.test/credenciais',
        'secret' => 'secret',
        'events' => ['credential.issued'],
        'is_active' => true,
    ]);

    $member = Member::create(['full_name' => 'Joao Alves']);
    MemberCredential::create([
        'member_id' => $member->id,
        'title' => 'Membro',
        'status' => 'active',
    ]);

    Http::assertSent(fn ($request): bool => $request->url() === 'https://integracao.test/credenciais'
        && $request['event'] === 'credential.issued');
});
