<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberCredential;
use App\Models\MemberCredentialTemplate;
use App\Models\SitePage;
use Illuminate\View\View;

class MemberCredentialController extends Controller
{
    public function print(MemberCredential $credential): View
    {
        $credential->load('member.category', 'template');

        return view('credentials.print', [
            'credential' => $credential,
            'template' => $credential->template ?? MemberCredentialTemplate::query()->where('is_active', true)->first(),
            'validationUrl' => route('credentials.validate', $credential->validation_token),
            'siteIdentity' => $this->siteIdentity(),
        ]);
    }

    public function validateCredential(string $token): View
    {
        $credential = MemberCredential::query()
            ->with('member.category', 'template')
            ->where('validation_token', $token)
            ->firstOrFail();

        return view('credentials.validate', [
            'credential' => $credential,
            'isValid' => $credential->isValid(),
        ]);
    }

    public function previewTemplate(MemberCredentialTemplate $template): View
    {
        $member = Member::query()->with('category')->first() ?? new Member([
            'full_name' => 'Nome do membro',
            'preferred_name' => 'Membro',
            'photos' => [],
        ]);

        if (! $member->relationLoaded('category')) {
            $member->setRelation('category', null);
        }

        $credential = new MemberCredential([
            'code' => 'CRD-PREVIA',
            'title' => 'Membro',
            'issued_on' => now()->toDateString(),
            'expires_on' => now()->addMonths($template->default_validity_months)->toDateString(),
            'status' => 'active',
        ]);
        $credential->setRelation('member', $member);
        $credential->setRelation('template', $template);

        return view('credentials.print', [
            'credential' => $credential,
            'template' => $template,
            'validationUrl' => '#',
            'siteIdentity' => $this->siteIdentity(),
        ]);
    }

    private function siteIdentity(): array
    {
        $page = SitePage::query()
            ->published()
            ->where('slug', 'home')
            ->first();
        $theme = collect($page?->blocks ?? [])->firstWhere('type', 'home_theme')['data'] ?? [];

        return [
            'church_name' => $theme['brand_name'] ?? null,
            'logo_image' => $theme['logo_image'] ?? null,
            'logo_mark_text' => $theme['logo_mark_text'] ?? null,
        ];
    }
}
