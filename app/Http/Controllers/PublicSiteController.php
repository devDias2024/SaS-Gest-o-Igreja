<?php

namespace App\Http\Controllers;

use App\Filament\Resources\SitePages\Schemas\SitePageForm;
use App\Models\BlogPost;
use App\Models\ChurchEvent;
use App\Models\Fund;
use App\Models\Member;
use App\Models\OnlineDonation;
use App\Models\PublicContact;
use App\Models\Sermon;
use App\Models\SitePage;
use App\Models\VisitorRegistration;
use App\Services\PublicSiteCommunication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicSiteController extends Controller
{
    public function home(): View
    {
        $page = SitePage::query()->published()->where('slug', 'home')->first()
            ?? SitePage::query()->published()->where('type', 'landing')->latest('updated_at')->latest('id')->first();

        return view('public-site.home', [
            'page' => $page,
            'events' => $this->upcomingEvents(4),
            'sermons' => $this->publishedSermons(3),
            'posts' => BlogPost::query()->published()->latest('published_at')->limit(3)->get(),
            'funds' => Fund::query()->where('accepts_online_donations', true)->orderBy('name')->get(),
            'menuPages' => $this->menuPages(),
            'homeContent' => $this->homeContent($page),
        ]);
    }

    public function page(string $slug): View
    {
        $page = SitePage::query()->published()->where('slug', $slug)->firstOrFail();

        return view('public-site.page', [
            'page' => $page,
            'menuPages' => $this->menuPages(),
        ]);
    }

    public function events(): View
    {
        return view('public-site.events', [
            'events' => $this->upcomingEvents(30),
            'menuPages' => $this->menuPages(),
        ]);
    }

    public function sermons(): View
    {
        return view('public-site.sermons', [
            'sermons' => $this->publishedSermons(18),
            'menuPages' => $this->menuPages(),
        ]);
    }

    public function blog(): View
    {
        return view('public-site.blog', [
            'posts' => BlogPost::query()->published()->latest('published_at')->paginate(9),
            'menuPages' => $this->menuPages(),
        ]);
    }

    public function blogPost(string $slug): View
    {
        return view('public-site.blog-post', [
            'post' => BlogPost::query()->published()->where('slug', $slug)->firstOrFail(),
            'menuPages' => $this->menuPages(),
        ]);
    }

    public function storeDonation(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'donor_name' => ['nullable', 'string', 'max:255'],
            'donor_email' => ['nullable', 'email', 'max:255'],
            'donor_phone' => ['nullable', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:1'],
            'fund_id' => ['nullable', 'exists:funds,id'],
            'payment_method' => ['required', 'in:pix,card,boleto'],
            'is_anonymous' => ['nullable', 'boolean'],
        ]);

        OnlineDonation::create($data + [
            'payment_gateway' => 'manual',
            'status' => 'pending',
            'payload' => [
                'origin' => 'public_site',
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ],
        ]);

        return back()->with('status', 'Sua doacao foi registrada. Em breve enviaremos as instrucoes de pagamento.');
    }

    public function storeContact(Request $request, PublicSiteCommunication $communication): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'contact_type' => ['nullable', 'in:contact,prayer'],
        ]);
        $isPrayerRequest = ($data['contact_type'] ?? 'contact') === 'prayer';
        unset($data['contact_type']);

        $thread = $communication->registerInboundLead(
            $data['name'],
            $data['email'] ?? null,
            $data['phone'] ?? null,
            $data['subject'] ?: 'Contato pelo site',
            $data['message'],
            ['origin' => $isPrayerRequest ? 'prayer_request' : 'public_contact', 'ip' => $request->ip()],
        );

        PublicContact::create($data + [
            'communication_inbox_thread_id' => $thread->id,
            'source' => $isPrayerRequest ? 'prayer' : 'site',
            'status' => 'new',
            'metadata' => ['ip' => $request->ip(), 'user_agent' => $request->userAgent()],
        ]);

        return back()->with('status', $isPrayerRequest
            ? 'Pedido recebido. Nossa equipe pastoral vai orar com voce.'
            : 'Mensagem enviada. Nossa equipe vai responder em breve.');
    }

    public function storeVisitor(Request $request, PublicSiteCommunication $communication): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'planned_visit_on' => ['nullable', 'date'],
            'preferred_service' => ['nullable', 'string', 'max:255'],
            'party_size' => ['nullable', 'integer', 'min:1', 'max:50'],
            'notes' => ['nullable', 'string', 'max:3000'],
        ]);

        $message = collect([
            'Novo visitante: '.$data['name'],
            filled($data['planned_visit_on'] ?? null) ? 'Data desejada: '.$data['planned_visit_on'] : null,
            filled($data['preferred_service'] ?? null) ? 'Culto/evento: '.$data['preferred_service'] : null,
            filled($data['party_size'] ?? null) ? 'Pessoas: '.$data['party_size'] : null,
            $data['notes'] ?? null,
        ])->filter()->implode("\n");

        $thread = $communication->registerInboundLead(
            $data['name'],
            $data['email'] ?? null,
            $data['phone'] ?? null,
            'Cadastro rapido de visitante',
            $message,
            ['origin' => 'visitor_registration', 'ip' => $request->ip()],
        );

        VisitorRegistration::create($data + [
            'communication_inbox_thread_id' => $thread->id,
            'party_size' => $data['party_size'] ?? 1,
            'status' => 'new',
            'metadata' => ['ip' => $request->ip(), 'user_agent' => $request->userAgent()],
        ]);

        return back()->with('status', 'Cadastro recebido. Vamos preparar sua visita com carinho.');
    }

    private function upcomingEvents(int $limit)
    {
        return ChurchEvent::query()
            ->with('location')
            ->where('status', 'scheduled')
            ->where('starts_at', '>=', now()->startOfDay())
            ->orderBy('starts_at')
            ->limit($limit)
            ->get();
    }

    private function publishedSermons(int $limit)
    {
        return Sermon::query()
            ->with(['preacher', 'primaryMedia'])
            ->where('status', 'published')
            ->where('visibility', 'public')
            ->latest('preached_at')
            ->limit($limit)
            ->get();
    }

    private function menuPages()
    {
        return SitePage::query()
            ->published()
            ->where('show_in_menu', true)
            ->orderBy('menu_order')
            ->orderBy('title')
            ->get();
    }

    private function homeContent(?SitePage $page): array
    {
        $defaults = SitePageForm::visualEditorDefaults();
        $memberCount = Member::query()->count();

        $theme = $this->homeBlock($page, 'home_theme', $defaults['home_theme']);
        $themeBlock = collect($page?->blocks ?? [])->firstWhere('type', 'home_theme')['data'] ?? [];

        if ($themeBlock !== [] && ! array_key_exists('surface_color', $themeBlock)) {
            $theme = array_replace($defaults['home_theme'], collect($themeBlock)->only([
                'brand_name',
                'logo_mark_text',
                'logo_image',
            ])->all());
        }

        return [
            'theme' => $theme,
            'hero' => $this->homeBlock($page, 'home_hero', $defaults['home_hero']),
            'about' => tap($this->homeBlock($page, 'home_about', $defaults['home_about']), function (&$about) use ($memberCount): void {
                if ($memberCount > 0 && isset($about['stats'][0])) {
                    $about['stats'][0]['value'] = number_format($memberCount, 0, ',', '.');
                }
            }),
            'live' => $this->homeBlock($page, 'home_live', $defaults['home_live']),
            'radio' => $this->homeBlock($page, 'home_radio', $defaults['home_radio']),
            'supporters' => $this->homeBlock($page, 'home_supporters', $defaults['home_supporters']),
            'prayer' => $this->homeBlock($page, 'home_prayer', $defaults['home_prayer']),
            'events_section' => $this->homeBlock($page, 'home_events', $defaults['home_events']),
            'ministries' => $this->homeBlock($page, 'home_ministries', $defaults['home_ministries']),
            'gallery' => $this->homeBlock($page, 'home_gallery', $defaults['home_gallery']),
            'app' => $this->homeBlock($page, 'home_app', $defaults['home_app']),
            'studies' => $this->homeBlock($page, 'home_studies', $defaults['home_studies']),
            'contact' => $this->homeBlock($page, 'home_contact', $defaults['home_contact']),
            'footer' => $this->homeBlock($page, 'home_footer', $defaults['home_footer']),
        ];
    }

    private function homeBlock(?SitePage $page, string $type, array $defaults): array
    {
        $block = collect($page?->blocks ?? [])->firstWhere('type', $type);

        return array_replace_recursive($defaults, $block['data'] ?? []);
    }
}
