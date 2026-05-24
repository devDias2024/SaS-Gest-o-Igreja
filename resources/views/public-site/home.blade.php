@php
    $assetUrl = function ($path, ?string $fallback = null) {
        $path = is_array($path) ? collect($path)->first() : $path;

        return filled($path) ? asset('storage/'.$path) : $fallback;
    };

    $theme = $homeContent['theme'];
    $hero = $homeContent['hero'];
    $about = $homeContent['about'];
    $live = $homeContent['live'];
    $radio = $homeContent['radio'];
    $supporters = $homeContent['supporters'];
    $prayer = $homeContent['prayer'];
    $eventsSection = $homeContent['events_section'];
    $ministries = $homeContent['ministries'];
    $gallery = $homeContent['gallery'];
    $appBlock = $homeContent['app'];
    $studies = $homeContent['studies'];
    $contact = $homeContent['contact'];
    $footer = $homeContent['footer'];
    $logo = $assetUrl($theme['logo_image'] ?? null);
    $heroImage = $assetUrl($hero['background_image'] ?? null, 'https://picsum.photos/seed/church-worship-gold/1920/1080');
    $aboutImage = $assetUrl($about['image'] ?? null, 'https://picsum.photos/seed/church-people-gathering/900/1000');
    $appImage = $assetUrl($appBlock['image'] ?? null, 'https://picsum.photos/seed/church-app-screen/360/640');
    $youtubeEmbedUrl = function (?string $url): ?string {
        if (blank($url)) {
            return null;
        }

        if (str_contains($url, '/embed/')) {
            return $url;
        }

        $parts = parse_url($url);
        $host = $parts['host'] ?? '';
        $path = trim($parts['path'] ?? '', '/');
        parse_str($parts['query'] ?? '', $query);

        $videoId = $query['v'] ?? null;

        if (! $videoId && str_contains($host, 'youtu.be')) {
            $videoId = $path;
        }

        if (! $videoId && str_contains($host, 'youtube.com') && str_starts_with($path, 'live/')) {
            $videoId = Str::after($path, 'live/');
        }

        if (! $videoId && str_contains($host, 'youtube.com') && str_starts_with($path, 'shorts/')) {
            $videoId = Str::after($path, 'shorts/');
        }

        return $videoId ? 'https://www.youtube.com/embed/'.$videoId.'?autoplay=0&rel=0' : $url;
    };
    $liveEmbedUrl = $youtubeEmbedUrl($live['video_url'] ?? null);
@endphp

<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $page?->meta_title ?: $theme['brand_name'] }}</title>
    @if($page?->meta_description)<meta name="description" content="{{ $page->meta_description }}">@endif
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800&family=Satisfy&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --bg: {{ $theme['background_color'] }};
            --surface: {{ $theme['surface_color'] }};
            --card: {{ $theme['card_color'] }};
            --gold: {{ $theme['gold_color'] }};
            --gold-light: {{ $theme['gold_light_color'] }};
            --text: {{ $theme['text_color'] }};
            --muted: {{ $theme['muted_color'] }};
            --nav-size: {{ (int) $theme['nav_font_size'] }}px;
            --heading-size: {{ (int) $theme['heading_font_size'] }}px;
            --body-size: {{ (int) $theme['body_font_size'] }}px;
            --button-size: {{ (int) $theme['button_font_size'] }}px;
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { margin: 0; overflow-x: hidden; background: var(--bg); color: var(--text); font-family: Inter, sans-serif; font-size: var(--body-size); }
        h1, h2, h3, h4 { font-family: "Playfair Display", serif; letter-spacing: 0; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 999px; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(34px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes shimmer { 0% { background-position: -200% center; } 100% { background-position: 200% center; } }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        @keyframes livePulse { 0%, 100% { opacity: 1; } 50% { opacity: .35; } }
        @keyframes equalizer1 { 0%, 100% { height: 8px; } 50% { height: 28px; } }
        @keyframes equalizer2 { 0%, 100% { height: 16px; } 50% { height: 36px; } }
        @keyframes particleFloat { 0% { transform: translateY(0); opacity: 0; } 10%, 90% { opacity: 1; } 100% { transform: translateY(-100vh) translateX(50px); opacity: 0; } }
        .font-display { font-family: "Playfair Display", serif; }
        .font-script { font-family: Satisfy, cursive; }
        .glass { background: rgba(255,255,255,.055); backdrop-filter: blur(14px); border: 1px solid rgba(255,255,255,.11); }
        .glass-dark { background: rgba(10,10,18,.82); backdrop-filter: blur(18px); border-bottom: 1px solid rgba(255,255,255,.08); }
        .shimmer-btn { background: linear-gradient(110deg, var(--gold) 0%, var(--gold-light) 25%, var(--gold) 50%, var(--gold-light) 75%, var(--gold) 100%); background-size: 200% 100%; animation: shimmer 3s linear infinite; color: #0a0a12; }
        .gold-card { background: linear-gradient(145deg, color-mix(in srgb, var(--gold) 8%, transparent), rgba(10,10,18,.92)); border: 1px solid color-mix(in srgb, var(--gold) 26%, transparent); transition: transform .35s, border-color .35s, box-shadow .35s; }
        .gold-card:hover { transform: translateY(-4px); border-color: color-mix(in srgb, var(--gold) 60%, transparent); box-shadow: 0 0 30px color-mix(in srgb, var(--gold) 15%, transparent); }
        .nav-link { position: relative; font-size: var(--nav-size); }
        .nav-link::after { content: ""; position: absolute; left: 50%; bottom: -4px; width: 0; height: 2px; background: var(--gold); transform: translateX(-50%); transition: width .25s; }
        .nav-link:hover::after { width: 100%; }
        .hero-overlay { background: linear-gradient(to bottom, rgba(10,10,18,.38), rgba(10,10,18,.62) 48%, rgba(10,10,18,.95) 86%, var(--bg)); }
        .reveal { opacity: 0; transform: translateY(30px); transition: all .8s ease-out; }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .particle { position: absolute; width: 3px; height: 3px; background: var(--gold); border-radius: 999px; animation: particleFloat linear infinite; opacity: 0; }
        .eq-bar { width: 4px; border-radius: 3px; background: linear-gradient(to top, var(--gold), var(--gold-light)); animation: equalizer1 .8s ease-in-out infinite; }
        .eq-bar:nth-child(2n) { animation-name: equalizer2; animation-duration: .65s; }
        .mobile-menu { transform: translateX(100%); transition: transform .3s ease; }
        .mobile-menu.open { transform: translateX(0); }
        .toast { position: fixed; left: 50%; bottom: 88px; transform: translateX(-50%) translateY(20px); opacity: 0; transition: all .35s; z-index: 9999; pointer-events: none; }
        .toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }
        input, textarea, select { color: #fff; }
        input::placeholder, textarea::placeholder { color: rgba(255,255,255,.35); }
    </style>
</head>
<body>
<div id="toast" class="toast glass rounded-xl px-6 py-3 text-sm font-semibold" style="color: var(--gold)"></div>
<div id="particles" class="fixed inset-0 pointer-events-none z-0"></div>

<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <a href="#inicio" class="flex items-center gap-3">
                @if($logo)
                    <img src="{{ $logo }}" alt="{{ $theme['brand_name'] }}" class="w-11 h-11 rounded-full object-cover ring-2" style="--tw-ring-color: var(--gold)">
                @else
                    <span class="w-11 h-11 rounded-full flex items-center justify-center text-lg font-bold font-display" style="background: linear-gradient(135deg,var(--gold-light),var(--gold)); color:#0a0a12">{{ $theme['logo_mark_text'] }}</span>
                @endif
                <span class="hidden sm:block leading-tight">
                    <span class="block font-display text-sm font-bold">{{ $theme['brand_short_name'] }}</span>
                    <span class="block text-[10px] uppercase tracking-[.24em]" style="color: var(--gold)">{{ $theme['brand_suffix'] }}</span>
                </span>
            </a>

            <div class="hidden lg:flex items-center gap-1">
                @foreach ([['#inicio','Inicio'],['#sobre','Sobre'],['#ministerios','Ministerios'],['#agenda','Agenda'],['#radio','Radio'],['#aovivo','Ao Vivo'],['#estudos','Estudos'],['#oracao','Oracao'],['#mantenedores','Mantenedores'],['#contato','Contato']] as [$url, $label])
                    <a href="{{ $url }}" class="nav-link px-3 py-2 text-white/80 hover:text-[var(--gold)] transition-colors">{{ $label }}</a>
                @endforeach
            </div>

            <div class="flex items-center gap-3">
                <a href="#mantenedores" class="hidden sm:inline-flex shimmer-btn rounded-full px-5 py-2.5 font-bold" style="font-size: var(--button-size)">Contribuir</a>
                <button id="menuToggle" class="lg:hidden w-10 h-10 rounded-lg glass flex items-center justify-center"><i data-lucide="menu" class="w-5 h-5"></i></button>
            </div>
        </div>
    </div>
</nav>

<div id="mobileMenu" class="mobile-menu fixed inset-y-0 right-0 w-72 z-[60] p-6 pt-20" style="background: rgba(10,10,18,.96)">
    <button id="menuClose" class="absolute top-6 right-6 text-white/60"><i data-lucide="x" class="w-6 h-6"></i></button>
    <div class="flex flex-col gap-1">
        @foreach ([['#inicio','Inicio'],['#sobre','Sobre'],['#ministerios','Ministerios'],['#agenda','Agenda'],['#radio','Radio Online'],['#aovivo','Ao Vivo'],['#estudos','Estudos'],['#oracao','Pedidos de Oracao'],['#mantenedores','Mantenedores'],['#galeria','Galeria'],['#contato','Contato']] as [$url, $label])
            <a href="{{ $url }}" class="mobile-link px-4 py-3 rounded-lg text-white/80 hover:bg-white/5 hover:text-[var(--gold)]">{{ $label }}</a>
        @endforeach
    </div>
</div>
<div id="menuOverlay" class="fixed inset-0 bg-black/60 z-[55] hidden"></div>

<section id="inicio" class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <img src="{{ $heroImage }}" alt="{{ $theme['brand_name'] }}" class="absolute inset-0 w-full h-full object-cover" id="heroBg">
    <div class="hero-overlay absolute inset-0"></div>
    <div class="absolute top-1/4 left-1/4 w-96 h-96 rounded-full blur-[120px]" style="background: color-mix(in srgb, var(--gold) 7%, transparent)"></div>
    <div class="relative z-10 text-center px-4 max-w-5xl mx-auto" style="animation: fadeInUp .9s ease-out both">
        <div class="inline-flex items-center gap-2 glass rounded-full px-5 py-2 mb-8">
            <span class="w-2 h-2 rounded-full" style="background: var(--gold)"></span>
            <span class="text-xs font-bold uppercase tracking-[.24em]" style="color: var(--gold)">{{ $hero['badge'] }}</span>
        </div>
        <h1 class="font-display text-5xl md:text-7xl lg:text-8xl font-bold leading-[1.05]">
            {{ $hero['title_prefix'] }} <span class="text-transparent bg-clip-text" style="background-image: linear-gradient(90deg,var(--gold-light),var(--gold))">{{ $hero['title_highlight'] }}</span>
        </h1>
        <h2 class="font-display text-3xl md:text-5xl font-light text-white/90 mt-3">{{ $hero['subtitle'] }}</h2>
        <p class="font-script text-2xl md:text-3xl mt-7" style="color: var(--gold)">{{ $hero['script_text'] }}</p>
        <p class="text-white/65 text-lg md:text-xl mt-3 mb-10">{{ $hero['description'] }}</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ $hero['primary_url'] }}" class="shimmer-btn rounded-full px-8 py-4 font-bold inline-flex items-center gap-2"><i data-lucide="tv" class="w-5 h-5"></i>{{ $hero['primary_label'] }}</a>
            <a href="{{ $hero['secondary_url'] }}" class="glass rounded-full px-8 py-4 font-bold inline-flex items-center gap-2 hover:bg-white/10"><i data-lucide="heart" class="w-5 h-5"></i>{{ $hero['secondary_label'] }}</a>
            <a href="{{ $hero['tertiary_url'] }}" class="rounded-full px-8 py-4 font-bold inline-flex items-center gap-2 border hover:bg-white/5" style="border-color: color-mix(in srgb, var(--gold) 42%, transparent); color: var(--gold)"><i data-lucide="map-pin" class="w-5 h-5"></i>{{ $hero['tertiary_label'] }}</a>
        </div>
    </div>
</section>

<section id="sobre" class="py-24 relative reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-16 items-center">
        <div class="relative">
            <img src="{{ $aboutImage }}" alt="{{ $about['heading'] }}" class="w-full h-[520px] object-cover rounded-2xl">
            <div class="absolute inset-0 rounded-2xl bg-gradient-to-t from-black/70 to-transparent"></div>
            <div class="absolute -bottom-6 -right-4 glass rounded-2xl p-6 max-w-[250px]">
                <div class="font-display text-4xl font-bold" style="color: var(--gold)">{{ $about['history_years'] }}</div>
                <p class="text-white/80 text-sm">{{ $about['history_label'] }}</p>
            </div>
        </div>
        <div>
            <p class="text-xs font-bold uppercase tracking-[.24em] mb-4" style="color: var(--gold)">{{ $about['eyebrow'] }}</p>
            <h2 class="font-display text-4xl md:text-5xl font-bold mb-6 leading-tight">{{ $about['heading'] }}</h2>
            <p class="text-white/60 leading-relaxed mb-5">{{ $about['body'] }}</p>
            <p class="text-white/60 leading-relaxed mb-8">{{ $about['body_two'] }}</p>
            <div class="grid grid-cols-2 gap-4">
                @foreach ($about['stats'] ?? [] as $stat)
                    <div class="text-center p-5 rounded-xl bg-white/5">
                        <div class="font-display text-3xl font-bold" style="color: var(--gold)">{{ $stat['value'] }}</div>
                        <div class="text-white/55 text-sm">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section id="aovivo" class="py-24 relative reveal">
    <div class="absolute inset-0" style="background: linear-gradient(180deg, transparent, color-mix(in srgb, var(--surface) 36%, transparent), transparent)"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 rounded-full px-4 py-2 mb-4 bg-red-500/15 border border-red-500/30">
                <span class="w-2.5 h-2.5 bg-red-500 rounded-full" style="animation: livePulse 1.5s infinite"></span>
                <span class="text-red-300 text-sm font-bold uppercase">{{ $live['eyebrow'] }}</span>
            </div>
            <h2 class="font-display text-4xl md:text-5xl font-bold">{{ $live['heading'] }}</h2>
            <p class="text-white/60 mt-4 max-w-2xl mx-auto">{{ $live['description'] }}</p>
        </div>
        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="gold-card rounded-2xl overflow-hidden">
                    <div class="aspect-video bg-black/50 flex items-center justify-center relative">
                        @if(filled($liveEmbedUrl))
                            <iframe src="{{ $liveEmbedUrl }}" class="absolute inset-0 w-full h-full" title="{{ $live['heading'] }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        @else
                            <div class="text-center">
                                <button type="button" onclick="showToast('Configure a URL da live no editor do painel.')" class="w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-4" style="background: color-mix(in srgb, var(--gold) 20%, transparent); color: var(--gold)"><i data-lucide="play" class="w-10 h-10 ml-1"></i></button>
                                <p class="text-white/60 text-sm">Clique para iniciar a transmissao</p>
                            </div>
                        @endif
                        <span class="absolute top-4 left-4 bg-red-600 rounded-lg px-3 py-1 text-sm font-bold">AO VIVO</span>
                    </div>
                </div>
                <div class="mt-6 grid sm:grid-cols-3 gap-4">
                    @foreach ($live['schedules'] ?? [] as $schedule)
                        <div class="glass rounded-xl p-4 text-center">
                            <div class="text-xs font-bold uppercase" style="color: var(--gold)">{{ $schedule['day'] }}</div>
                            <div class="font-semibold">{{ $schedule['title'] }}</div>
                            <div class="text-white/50 text-sm">{{ $schedule['time'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="glass rounded-2xl p-5 h-[420px] flex flex-col">
                <div class="flex justify-between border-b border-white/10 pb-3 mb-4"><b>Chat ao Vivo</b><span class="text-white/40 text-sm"><span id="liveOnlineCount">0</span> online</span></div>
                <div id="chatMessages" class="flex-1 overflow-y-auto space-y-3 text-sm text-white/70">
                    <p class="text-white/35">Carregando mensagens...</p>
                </div>
                <div class="grid gap-2 pt-4">
                    <input id="chatName" class="bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-sm" maxlength="80" placeholder="Seu nome">
                    <div class="flex gap-2">
                    <input id="chatInput" class="flex-1 bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-sm" maxlength="600" placeholder="Digite sua mensagem...">
                    <button id="chatSend" class="rounded-lg px-3" style="background:var(--gold);color:#0a0a12"><i data-lucide="send" class="w-4 h-4"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="radio" class="py-24 reveal">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-xs font-bold uppercase tracking-[.24em] mb-4" style="color: var(--gold)">{{ $radio['eyebrow'] }}</p>
            <h2 class="font-display text-4xl md:text-5xl font-bold">{{ $radio['heading'] }}</h2>
            <p class="text-white/60 mt-4">{{ $radio['description'] }}</p>
        </div>
        <div class="relative rounded-3xl overflow-hidden gold-card p-8 md:p-12">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex items-center gap-6">
                    <div class="flex items-end gap-1 h-10">@for($i = 0; $i < 7; $i++)<div class="eq-bar"></div>@endfor</div>
                    <div>
                        <div class="text-xs font-bold uppercase" style="color: var(--gold)">Tocando agora</div>
                        <h3 id="currentSong" class="font-display text-xl font-bold">{{ $radio['current_song'] }}</h3>
                        <p class="text-white/40 text-sm">Locutor: {{ $radio['host'] }}</p>
                    </div>
                </div>
                <button id="radioPlayBtn" class="w-16 h-16 rounded-full flex items-center justify-center" style="background:var(--gold);color:#0a0a12"><i data-lucide="play" id="radioPlayIcon" class="w-7 h-7 ml-1"></i></button>
                @if(filled($radio['stream_url']))
                    <audio id="radioAudio" src="{{ $radio['stream_url'] }}"></audio>
                @endif
            </div>
        </div>
    </div>
</section>

<section id="mantenedores" class="py-24 relative reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-xs font-bold uppercase tracking-[.24em] mb-4" style="color: var(--gold)">{{ $supporters['eyebrow'] }}</p>
            <h2 class="font-display text-4xl md:text-5xl font-bold">{{ $supporters['heading'] }}</h2>
            <p class="text-white/60 mt-4 max-w-2xl mx-auto">{{ $supporters['description'] }}</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6 mb-12">
            @foreach ($supporters['plans'] ?? [] as $plan)
                <div class="gold-card rounded-2xl p-8 text-center">
                    <i data-lucide="{{ $loop->last ? 'crown' : 'heart' }}" class="w-10 h-10 mx-auto mb-4" style="color: var(--gold)"></i>
                    <h3 class="font-display text-2xl font-bold mb-2">{{ $plan['name'] }}</h3>
                    <div class="text-3xl font-black mb-1" style="color: var(--gold)">R$ {{ $plan['amount'] }}<span class="text-base text-white/40">/mes</span></div>
                    <p class="text-white/40 text-sm mb-6">{{ $plan['description'] }}</p>
                    <ul class="text-left space-y-3 mb-8">
                        @foreach (array_filter(array_map('trim', explode(';', $plan['benefits'] ?? ''))) as $benefit)
                            <li class="flex gap-2 text-white/70 text-sm"><i data-lucide="check" class="w-4 h-4 shrink-0" style="color: var(--gold)"></i>{{ $benefit }}</li>
                        @endforeach
                    </ul>
                    <form method="post" action="{{ route('public.donations.store') }}">
                        @csrf
                        <input type="hidden" name="amount" value="{{ $plan['amount'] }}">
                        <input type="hidden" name="payment_method" value="pix">
                        <button class="w-full shimmer-btn rounded-full py-3 font-bold">Contribuir</button>
                    </form>
                </div>
            @endforeach
        </div>
        <div class="glass rounded-2xl p-8 max-w-xl mx-auto text-center">
            <h3 class="font-display text-xl font-bold mb-2">Doacao via PIX</h3>
            <p class="text-white/50 text-sm mb-4">Copie a chave para contribuir</p>
            <div class="flex items-center gap-2 bg-white/5 rounded-lg px-4 py-3">
                <code id="pixKey" class="flex-1 text-sm" style="color: var(--gold)">{{ $supporters['pix_key'] }}</code>
                <button onclick="copyPix()" type="button"><i data-lucide="copy" class="w-4 h-4"></i></button>
            </div>
        </div>
        <div class="mt-12 grid md:grid-cols-2 gap-6">
            @foreach ($supporters['goals'] ?? [] as $goal)
                <div class="glass rounded-2xl p-6">
                    <h4 class="font-display text-lg font-bold mb-3">{{ $goal['title'] }}</h4>
                    <div class="w-full bg-white/10 rounded-full h-3 mb-2"><div class="h-3 rounded-full" style="width: {{ min(100, max(0, (int) $goal['percent'])) }}%; background: linear-gradient(90deg,var(--gold),var(--gold-light))"></div></div>
                    <div class="flex justify-between text-sm"><span class="text-white/50">{{ $goal['current'] }}</span><span style="color:var(--gold)">{{ $goal['percent'] }}%</span></div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="oracao" class="py-24 reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-8">
        <div>
            <p class="text-xs font-bold uppercase tracking-[.24em] mb-4" style="color:var(--gold)">{{ $prayer['eyebrow'] }}</p>
            <h2 class="font-display text-4xl md:text-5xl font-bold mb-4">{{ $prayer['heading'] }}</h2>
            <p class="text-white/60 mb-8">{{ $prayer['description'] }}</p>
            <form class="glass rounded-2xl p-8 space-y-4" method="post" action="{{ route('public.contacts.store') }}">
                @csrf
                <input type="hidden" name="contact_type" value="prayer">
                <input type="hidden" name="subject" value="Pedido de oracao pelo site">
                <input name="name" placeholder="Nome" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3">
                <input name="phone" placeholder="Telefone/WhatsApp" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3">
                <textarea name="message" required rows="5" placeholder="Compartilhe seu pedido de oracao..." class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3"></textarea>
                <button class="w-full shimmer-btn rounded-full py-3 font-bold">Enviar Pedido</button>
            </form>
        </div>
        <div class="space-y-4">
            @foreach (['Familia' => 'Orem pela restauracao da minha casa.', 'Saude' => 'Peco oracao por cura e fortalecimento.', 'Espiritual' => 'Preciso de renovo e direcao de Deus.'] as $category => $message)
                <div class="glass rounded-xl p-5">
                    <div class="flex justify-between mb-2"><span class="text-sm font-bold" style="color:var(--gold)">{{ $category }}</span><button type="button" onclick="showToast('Obrigado por orar junto.')" class="text-white/40"><i data-lucide="heart" class="w-4 h-4"></i></button></div>
                    <p class="text-white/70 text-sm">{{ $message }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="agenda" class="py-24 reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-xs font-bold uppercase tracking-[.24em] mb-4" style="color:var(--gold)">{{ $eventsSection['eyebrow'] }}</p>
            <h2 class="font-display text-4xl md:text-5xl font-bold">{{ $eventsSection['heading'] }}</h2>
            <p class="text-white/60 mt-4">{{ $eventsSection['description'] }}</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($events as $event)
                <article class="gold-card rounded-2xl overflow-hidden">
                    <img src="https://picsum.photos/seed/event-{{ $event->id }}/600/360" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <p class="text-xs font-bold mb-2" style="color:var(--gold)">{{ $event->starts_at->format('d/m/Y H:i') }}</p>
                        <h3 class="font-display text-xl font-bold mb-2">{{ $event->title }}</h3>
                        <p class="text-white/50 text-sm mb-4">{{ $event->location?->name ?: 'Local a confirmar' }}</p>
                        <button type="button" onclick="showToast('Presenca confirmada.')" class="w-full rounded-full border py-2 text-sm font-bold" style="border-color:color-mix(in srgb,var(--gold) 45%,transparent);color:var(--gold)">Confirmar Presenca</button>
                    </div>
                </article>
            @empty
                <div class="glass rounded-2xl p-8 text-white/60 col-span-full text-center">Nenhum evento publicado no momento.</div>
            @endforelse
        </div>
    </div>
</section>

<section id="ministerios" class="py-24 reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-xs font-bold uppercase tracking-[.24em] mb-4" style="color:var(--gold)">{{ $ministries['eyebrow'] }}</p>
            <h2 class="font-display text-4xl md:text-5xl font-bold">{{ $ministries['heading'] }}</h2>
            <p class="text-white/60 mt-4">{{ $ministries['description'] }}</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($ministries['items'] ?? [] as $ministry)
                <article class="gold-card rounded-2xl p-6 text-center">
                    <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center mx-auto mb-4"><i data-lucide="{{ $ministry['icon'] ?: 'users' }}" class="w-7 h-7" style="color:var(--gold)"></i></div>
                    <h3 class="font-display text-xl font-bold">{{ $ministry['title'] }}</h3>
                    <p class="text-white/40 text-sm mb-3">{{ $ministry['subtitle'] }}</p>
                    <p class="text-white/55 text-sm mb-4">{{ $ministry['description'] }}</p>
                    <p class="text-white/35 text-xs">{{ $ministry['leader'] }}</p>
                    <p class="text-white/35 text-xs">{{ $ministry['schedule'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section id="galeria" class="py-24 reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-xs font-bold uppercase tracking-[.24em] mb-4" style="color:var(--gold)">{{ $gallery['eyebrow'] }}</p>
            <h2 class="font-display text-4xl md:text-5xl font-bold">{{ $gallery['heading'] }}</h2>
            <p class="text-white/60 mt-4">{{ $gallery['description'] }}</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @forelse ($gallery['items'] ?? [] as $item)
                <img src="{{ $assetUrl($item['image'] ?? null, 'https://picsum.photos/seed/gallery-'.$loop->index.'/600/600') }}" alt="{{ $item['title'] ?? 'Galeria' }}" class="rounded-xl aspect-square object-cover hover:scale-[1.03] transition-transform">
            @empty
                @for ($i = 1; $i <= 8; $i++)
                    <img src="https://picsum.photos/seed/church-gallery-{{ $i }}/600/600" alt="Galeria" class="rounded-xl aspect-square object-cover hover:scale-[1.03] transition-transform">
                @endfor
            @endforelse
        </div>
    </div>
</section>

<section id="app" class="py-24 reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="glass rounded-3xl overflow-hidden grid lg:grid-cols-2">
            <div class="p-10 md:p-16">
                <p class="text-xs font-bold uppercase tracking-[.24em] mb-4" style="color:var(--gold)">{{ $appBlock['eyebrow'] }}</p>
                <h2 class="font-display text-3xl md:text-4xl font-bold mb-4">{{ $appBlock['heading'] }}</h2>
                <p class="text-white/60 mb-8">{{ $appBlock['description'] }}</p>
                <div class="flex flex-wrap gap-3 mb-8">
                    @foreach (['Cultos Ao Vivo','Radio 24h','Biblia & Estudos','Agenda','Doacoes'] as $feature)
                        <span class="glass rounded-lg px-4 py-2 text-sm text-white/70">{{ $feature }}</span>
                    @endforeach
                </div>
                <div class="flex gap-4 flex-wrap">
                    <a href="{{ $appBlock['app_store_url'] }}" class="bg-white text-black rounded-xl px-5 py-3 font-bold">App Store</a>
                    <a href="{{ $appBlock['google_play_url'] }}" class="bg-white text-black rounded-xl px-5 py-3 font-bold">Google Play</a>
                </div>
            </div>
            <div class="p-8 flex items-center justify-center" style="background: color-mix(in srgb,var(--gold) 10%, transparent)">
                <img src="{{ $appImage }}" alt="{{ $appBlock['heading'] }}" class="w-56 h-[420px] rounded-[2rem] object-cover shadow-2xl border border-white/10">
            </div>
        </div>
    </div>
</section>

<section id="estudos" class="py-24 reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-xs font-bold uppercase tracking-[.24em] mb-4" style="color:var(--gold)">{{ $studies['eyebrow'] }}</p>
            <h2 class="font-display text-4xl md:text-5xl font-bold">{{ $studies['heading'] }}</h2>
            <p class="text-white/60 mt-4">{{ $studies['description'] }}</p>
        </div>
        <div class="gold-card rounded-2xl p-8 md:p-12 text-center mb-8">
            <p class="font-display text-2xl md:text-3xl italic mb-4">"{{ $studies['verse'] }}"</p>
            <p style="color:var(--gold)" class="font-display text-lg">{{ $studies['verse_ref'] }}</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @forelse ($posts as $post)
                <a href="{{ route('public.blog.show', $post->slug) }}" class="gold-card rounded-2xl p-6 block">
                    <p class="text-xs font-bold mb-3" style="color:var(--gold)">{{ $post->category ?: 'Estudo' }}</p>
                    <h3 class="font-display text-xl font-bold mb-2">{{ $post->title }}</h3>
                    <p class="text-white/50 text-sm">{{ $post->excerpt ?: 'Leia este conteudo no blog da igreja.' }}</p>
                </a>
            @empty
                @foreach (['O Poder da Gratidao','Carta aos Romanos','Biblia em 1 Ano'] as $title)
                    <div class="gold-card rounded-2xl p-6"><h3 class="font-display text-xl font-bold mb-2">{{ $title }}</h3><p class="text-white/50 text-sm">Conteudo em breve.</p></div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

<section id="contato" class="py-24 reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-xs font-bold uppercase tracking-[.24em] mb-4" style="color:var(--gold)">{{ $contact['eyebrow'] }}</p>
            <h2 class="font-display text-4xl md:text-5xl font-bold">{{ $contact['heading'] }}</h2>
            <p class="text-white/60 mt-4">{{ $contact['description'] }}</p>
        </div>
        <div class="grid lg:grid-cols-2 gap-8">
            <div class="rounded-2xl overflow-hidden min-h-[400px] relative glass">
                @if(filled($contact['map_embed_url']))
                    <iframe src="{{ $contact['map_embed_url'] }}" class="absolute inset-0 w-full h-full" style="border:0; filter: grayscale(.45) brightness(.75)" loading="lazy"></iframe>
                @else
                    <div class="absolute inset-0 flex items-center justify-center text-center p-8 text-white/60">Configure a URL embed do Google Maps no editor.</div>
                @endif
                <div class="absolute bottom-4 left-4 right-4 glass rounded-xl p-4">
                    <b>{{ $theme['brand_name'] }}</b>
                    <p class="text-white/55 text-sm">{{ $contact['address'] }}</p>
                </div>
            </div>
            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    @foreach ([['phone','Telefone',$contact['phone']],['mail','E-mail',$contact['email']],['clock','Secretaria',$contact['office_hours']],['message-circle','WhatsApp',$contact['whatsapp']]] as [$icon, $label, $value])
                        <div class="glass rounded-xl p-4 text-center"><i data-lucide="{{ $icon }}" class="w-6 h-6 mx-auto mb-2" style="color:var(--gold)"></i><p class="text-white/45 text-xs">{{ $label }}</p><p class="text-sm font-bold">{{ $value }}</p></div>
                    @endforeach
                </div>
                <form class="glass rounded-2xl p-6 space-y-3" method="post" action="{{ route('public.contacts.store') }}">
                    @csrf
                    <h3 class="font-display text-xl font-bold mb-4">Fale Conosco</h3>
                    <div class="grid sm:grid-cols-2 gap-3">
                        <input name="name" required placeholder="Nome" class="bg-white/5 border border-white/10 rounded-xl px-4 py-3">
                        <input name="email" type="email" placeholder="E-mail" class="bg-white/5 border border-white/10 rounded-xl px-4 py-3">
                    </div>
                    <input name="subject" placeholder="Assunto" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3">
                    <textarea name="message" required rows="4" placeholder="Sua mensagem..." class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3"></textarea>
                    <button class="w-full shimmer-btn rounded-full py-3 font-bold">Enviar Mensagem</button>
                </form>
            </div>
        </div>
    </div>
</section>

<footer class="relative pt-20 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    @if($logo)<img src="{{ $logo }}" class="w-10 h-10 rounded-full object-cover" alt="{{ $theme['brand_name'] }}">@else<span class="w-10 h-10 rounded-full flex items-center justify-center font-bold" style="background:var(--gold);color:#0a0a12">{{ $theme['logo_mark_text'] }}</span>@endif
                    <div><b class="font-display">{{ $theme['brand_short_name'] }}</b><p class="text-xs uppercase tracking-[.2em]" style="color:var(--gold)">{{ $theme['brand_suffix'] }}</p></div>
                </div>
                <p class="text-white/40 text-sm leading-relaxed">{{ $footer['description'] }}</p>
            </div>
            <div><h4 class="font-display font-bold mb-4">Horarios dos Cultos</h4>@foreach($live['schedules'] ?? [] as $schedule)<p class="flex justify-between text-sm text-white/50 mb-2"><span>{{ $schedule['title'] }}</span><span style="color:var(--gold)">{{ $schedule['time'] }}</span></p>@endforeach</div>
            <div><h4 class="font-display font-bold mb-4">Links Rapidos</h4>@foreach([['#sobre','Sobre Nos'],['#ministerios','Ministerios'],['#aovivo','Culto Ao Vivo'],['#radio','Radio Online'],['#estudos','Estudos'],['#oracao','Pedidos de Oracao'],['#mantenedores','Seja Mantenedor']] as [$url,$label])<a href="{{ $url }}" class="block text-white/50 text-sm mb-2 hover:text-[var(--gold)]">{{ $label }}</a>@endforeach</div>
            <div><h4 class="font-display font-bold mb-4">Contato</h4><p class="text-white/50 text-sm mb-2">{{ $contact['address'] }}</p><p class="text-white/50 text-sm mb-2">{{ $contact['phone'] }}</p><p class="text-white/50 text-sm">{{ $contact['email'] }}</p></div>
        </div>
        <div class="text-center py-8 border-t border-white/10 mb-8">
            <p class="font-script text-2xl" style="color:var(--gold)">"{{ $footer['verse'] }}"</p>
            <p class="text-white/30 text-sm mt-2">{{ $footer['verse_ref'] }}</p>
        </div>
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-white/30 text-xs">
            <p>Copyright &copy; {{ now()->year }} {{ $theme['brand_name'] }}.</p>
            <p>Desenvolvido para {{ $theme['brand_short_name'] }}</p>
        </div>
    </div>
</footer>

<div id="radioFloating" class="fixed bottom-0 left-0 right-0 z-50 translate-y-full transition-transform duration-500 glass-dark">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3 min-w-0">
            <div class="flex items-end gap-0.5 h-5">@for($i = 0; $i < 5; $i++)<div class="eq-bar" style="width:3px"></div>@endfor</div>
            <div class="min-w-0"><div id="floatingSong" class="text-sm font-bold truncate">{{ $radio['current_song'] }}</div><div class="text-white/40 text-xs">{{ $radio['heading'] }}</div></div>
        </div>
        <div class="flex items-center gap-3">
            <button id="floatingPlayBtn" class="w-10 h-10 rounded-full flex items-center justify-center" style="background:var(--gold);color:#0a0a12"><i data-lucide="play" id="floatingPlayIcon" class="w-4 h-4 ml-0.5"></i></button>
            <button id="floatingClose" class="text-white/40"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
    </div>
</div>

@if(session('status'))
    <script>window.addEventListener('DOMContentLoaded', () => showToast(@json(session('status'))));</script>
@endif

<script>
    lucide.createIcons();

    const particles = document.getElementById('particles');
    for (let i = 0; i < 20; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.top = Math.random() * 100 + '%';
        particle.style.animationDuration = (8 + Math.random() * 15) + 's';
        particle.style.animationDelay = Math.random() * 10 + 's';
        particles.appendChild(particle);
    }

    const navbar = document.getElementById('navbar');
    addEventListener('scroll', () => {
        navbar.classList.toggle('glass-dark', scrollY > 80);
        const heroBg = document.getElementById('heroBg');
        if (heroBg) heroBg.style.transform = `translateY(${scrollY * .25}px)`;
    });

    const mobileMenu = document.getElementById('mobileMenu');
    const menuOverlay = document.getElementById('menuOverlay');
    const openMenu = () => { mobileMenu.classList.add('open'); menuOverlay.classList.remove('hidden'); };
    const closeMenu = () => { mobileMenu.classList.remove('open'); menuOverlay.classList.add('hidden'); };
    document.getElementById('menuToggle').addEventListener('click', openMenu);
    document.getElementById('menuClose').addEventListener('click', closeMenu);
    menuOverlay.addEventListener('click', closeMenu);
    document.querySelectorAll('.mobile-link').forEach((link) => link.addEventListener('click', closeMenu));

    const observer = new IntersectionObserver((entries) => entries.forEach((entry) => {
        if (entry.isIntersecting) entry.target.classList.add('visible');
    }), { threshold: .1, rootMargin: '0px 0px -50px 0px' });
    document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));

    const chatName = document.getElementById('chatName');
    const chatInput = document.getElementById('chatInput');
    const chatSend = document.getElementById('chatSend');
    const chatMessages = document.getElementById('chatMessages');
    let lastChatHtml = '';

    const escapeHtml = (value) => String(value ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');

    async function loadLiveChat() {
        if (!chatMessages) return;

        try {
            const response = await fetch(@json(route('public.live-chat.index')), {
                headers: { 'Accept': 'application/json' },
            });
            const data = await response.json();
            updateOnlineCount(data.online_count);
            const html = (data.messages || []).map((item) => `
                <p>
                    <b style="color:var(--gold)">${escapeHtml(item.name)}:</b>
                    ${escapeHtml(item.message)}
                    <span class="block text-white/30 text-[11px]">${escapeHtml(item.time)}</span>
                </p>
            `).join('') || '<p class="text-white/35">Nenhuma mensagem ainda. Seja o primeiro a escrever.</p>';

            if (html !== lastChatHtml) {
                lastChatHtml = html;
                chatMessages.innerHTML = html;
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        } catch (error) {
            chatMessages.innerHTML = '<p class="text-white/35">Nao foi possivel carregar o chat agora.</p>';
        }
    }

    async function sendLiveChatMessage() {
        const msg = chatInput.value.trim();
        if (!msg) return;

        chatSend.disabled = true;

        try {
            await fetch(@json(route('public.live-chat.store')), {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || @json(csrf_token()),
                },
                body: JSON.stringify({
                    name: chatName.value.trim(),
                    message: msg,
                }),
            });

            chatInput.value = '';
            await loadLiveChat();
        } catch (error) {
            showToast('Nao foi possivel enviar a mensagem.');
        } finally {
            chatSend.disabled = false;
        }
    }

    function updateOnlineCount(count) {
        const el = document.getElementById('liveOnlineCount');
        if (el && Number.isFinite(Number(count))) {
            el.textContent = Number(count);
        }
    }

    async function sendLiveHeartbeat() {
        try {
            const response = await fetch(@json(route('public.live-chat.heartbeat')), {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || @json(csrf_token()),
                },
                body: JSON.stringify({}),
            });
            const data = await response.json();
            updateOnlineCount(data.online_count);
        } catch (error) {
            // Mantem o ultimo numero conhecido.
        }
    }

    chatSend?.addEventListener('click', sendLiveChatMessage);
    chatInput?.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') sendLiveChatMessage();
    });
    loadLiveChat();
    sendLiveHeartbeat();
    setInterval(loadLiveChat, 5000);
    setInterval(sendLiveHeartbeat, 15000);

    let radioPlaying = false;
    const audio = document.getElementById('radioAudio');
    const setRadioState = (playing) => {
        radioPlaying = playing;
        ['radioPlayIcon', 'floatingPlayIcon'].forEach((id) => document.getElementById(id)?.setAttribute('data-lucide', playing ? 'pause' : 'play'));
        document.getElementById('radioFloating').style.transform = playing ? 'translateY(0)' : '';
        lucide.createIcons();
    };
    const toggleRadio = () => {
        if (audio) radioPlaying ? audio.pause() : audio.play().catch(() => showToast('Nao foi possivel iniciar a radio.'));
        setRadioState(!radioPlaying);
    };
    document.getElementById('radioPlayBtn')?.addEventListener('click', toggleRadio);
    document.getElementById('floatingPlayBtn')?.addEventListener('click', toggleRadio);
    document.getElementById('floatingClose')?.addEventListener('click', () => document.getElementById('radioFloating').style.transform = 'translateY(100%)');

    function copyPix() {
        const key = document.getElementById('pixKey').textContent.trim();
        navigator.clipboard?.writeText(key).then(() => showToast('Chave PIX copiada.')).catch(() => showToast(key));
    }

    function showToast(message) {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3200);
    }
</script>
</body>
</html>
