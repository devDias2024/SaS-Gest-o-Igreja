<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Igreja') }}</title>
    <meta name="description" content="{{ $description ?? 'Site publico da igreja' }}">
    @php
        if (empty($theme)) {
            $homePage = \App\Models\SitePage::query()->published()->where('slug', 'home')->first();
            $theme = collect($homePage?->blocks ?? [])->firstWhere('type', 'home_theme')['data'] ?? [];
        }

        $themeAsset = function ($path) {
            $path = is_array($path) ? collect($path)->first() : $path;

            return filled($path) ? asset('storage/'.$path) : null;
        };

        $brandName = $theme['brand_name'] ?? config('app.name', 'Igreja');
        $logoMark = $theme['logo_mark_text'] ?? 'AD';
        $logoImage = $themeAsset($theme['logo_image'] ?? null);
    @endphp
    <style>
        :root{--green:{{ $theme['primary_color'] ?? '#005f51' }};--green-dark:{{ $theme['primary_dark_color'] ?? '#003c33' }};--green-soft:{{ $theme['primary_soft_color'] ?? '#087264' }};--cream:{{ $theme['cream_color'] ?? '#fff2bc' }};--orange:{{ $theme['accent_color'] ?? '#ff941f' }};--ink:{{ $theme['text_color'] ?? '#392f31' }};--muted:{{ $theme['muted_color'] ?? '#756b68' }};--paper:{{ $theme['background_color'] ?? '#f7f7f5' }};--line:#ece7df;--nav-font:{{ (int) ($theme['nav_font_size'] ?? 11) }}px;--brand-font:{{ (int) ($theme['brand_font_size'] ?? 13) }}px;--heading-font:{{ (int) ($theme['heading_font_size'] ?? 47) }}px;--body-font:{{ (int) ($theme['body_font_size'] ?? 16) }}px;--button-font:{{ (int) ($theme['button_font_size'] ?? 11) }}px}
        *{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;font-family:Inter,Montserrat,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;color:var(--ink);background:var(--paper);line-height:1.5;font-size:var(--body-font)}a{color:inherit;text-decoration:none}img{display:block;max-width:100%}.wrap{width:min(1160px,calc(100% - 36px));margin-inline:auto}.top{position:sticky;top:0;z-index:20;background:color-mix(in srgb,var(--green) 96%,transparent);box-shadow:0 1px 0 rgba(255,255,255,.08);backdrop-filter:blur(12px)}.nav{min-height:54px;display:flex;align-items:center;justify-content:space-between;gap:24px}.brand{display:flex;align-items:center;gap:10px;color:#fff;font-weight:800;font-size:var(--brand-font);letter-spacing:.04em;text-transform:uppercase}.brand-mark,.footer-mark,.seal{display:grid;place-items:center;border-radius:999px;background:#f5e6a8;color:var(--green);font-weight:900}.brand-mark{width:26px;height:26px}.links{display:flex;align-items:center;gap:22px;font-size:var(--nav-font);color:#cfe7e2;text-transform:uppercase;font-weight:800;letter-spacing:.04em;flex-wrap:wrap}.links a:not(.button):hover{color:#fff}.button{display:inline-flex;align-items:center;justify-content:center;border-radius:6px;padding:11px 16px;background:var(--green);color:#fff;font-weight:800;border:1px solid var(--green);cursor:pointer;text-transform:uppercase;font-size:var(--button-font);letter-spacing:.03em}.button.secondary{background:transparent;color:#fff;border-color:rgba(255,255,255,.35)}.button.light{background:#fff;color:var(--green);border-color:#fff}.button.warm{background:var(--orange);border-color:var(--orange);color:#fff}.hero{position:relative;min-height:430px;background:linear-gradient(color-mix(in srgb,var(--green) 88%,transparent),color-mix(in srgb,var(--green-dark) 90%,transparent)),radial-gradient(circle at 50% 18%,rgba(255,255,255,.08),transparent 28%),linear-gradient(150deg,var(--green-dark),var(--green) 50%,var(--green-dark));overflow:hidden}.hero:before{content:"";position:absolute;inset:auto -5% 0;height:58%;background:linear-gradient(to top,rgba(0,35,30,.85),transparent),repeating-radial-gradient(ellipse at 50% 100%,rgba(255,255,255,.1) 0 1px,transparent 1px 9px);clip-path:polygon(0 38%,18% 30%,39% 45%,63% 28%,82% 34%,100% 25%,100% 100%,0 100%);z-index:1}.hero-slider{position:relative;z-index:2}.hero-slide{display:none;min-height:430px;padding:44px 0 72px;background-size:cover;background-position:center}.hero-slide:first-child{display:block}.hero.is-slider .hero-slide{animation:heroFade 18s infinite}.hero.is-slider .hero-slide:nth-child(2){animation-delay:6s}.hero.is-slider .hero-slide:nth-child(3){animation-delay:12s}@keyframes heroFade{0%,31%{display:block;opacity:1}33%,100%{display:none;opacity:0}}.hero-inner{position:relative;z-index:3;text-align:center;color:var(--hero-text,#f7e7a7)}.hero-logo{margin:0 auto 30px;width:120px;color:var(--hero-text,#e7d891);font-size:12px;font-weight:900;text-transform:uppercase}.anniversary{display:flex;justify-content:center;align-items:center;gap:24px;line-height:.86;letter-spacing:-.05em}.anniversary strong{font-size:clamp(42px,16vw,var(--hero-main-font,168px));font-weight:950}.anniversary span{font-size:clamp(38px,13vw,var(--hero-side-font,134px));font-weight:950}.anniversary small{display:block;max-width:180px;text-align:left;font-size:var(--hero-tagline-font,15px);line-height:1.15;letter-spacing:.1em;text-transform:uppercase;font-weight:900;color:var(--hero-accent,#f4d77a)}.hero-caption{margin-top:18px;color:var(--hero-text,#f5dda2);text-transform:uppercase;font-size:var(--hero-caption-font,13px);font-weight:900;letter-spacing:.22em}.tile-strip{height:76px;background:repeating-linear-gradient(90deg,#105fb0 0 58px,#f29d21 58px 116px,var(--green) 116px 174px,#e9442d 174px 232px,#f5d686 232px 290px);position:relative}.tile-strip:after{content:"";position:absolute;inset:0;background:repeating-linear-gradient(90deg,transparent 0 54px,rgba(255,255,255,.42) 54px 56px),radial-gradient(circle at 24px 28px,rgba(255,255,255,.8) 0 8px,transparent 9px);mix-blend-mode:soft-light}.intro{padding:78px 0 76px;background:#fafafa}.intro-grid{display:grid;grid-template-columns:1.05fr .95fr;gap:70px;align-items:center}.eyebrow{text-transform:uppercase;font-size:11px;font-weight:900;color:#a29a95;letter-spacing:.32em}.section-title,.intro h1{font-size:clamp(28px,4.2vw,var(--heading-font));line-height:1.05;margin:10px 0 18px;color:var(--ink);font-weight:700;letter-spacing:0}.intro p,.lead,.muted{color:var(--muted)}.actions{display:flex;gap:14px;flex-wrap:wrap;margin-top:26px}.play-link{display:inline-flex;align-items:center;gap:10px;color:var(--green);font-size:13px;font-weight:800}.play-link i{display:grid;place-items:center;width:48px;height:48px;border-radius:999px;background:var(--green);color:#fff;font-style:normal}.stats-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}.stat-card{min-height:120px;border-radius:16px;background:#fffdf8;display:grid;place-items:center;text-align:center;box-shadow:0 18px 45px rgba(42,35,30,.04)}.stat-card b{font-size:36px;color:var(--green-soft);font-weight:500}.stat-card span{font-size:12px;color:#958b86}.section{padding:70px 0}.section.deep{background:var(--green);color:#f6e8b8;border-radius:42px;margin:0 auto;width:min(100%,1440px)}.section.deep .section-title{color:#f6e8b8;text-align:center}.section.deep .eyebrow{text-align:center;color:#d7cfa5}.section-head{display:flex;align-items:end;justify-content:space-between;gap:24px;margin-bottom:30px}.grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:22px}.card{border-radius:14px;background:#fff;padding:18px;border:1px solid var(--line);box-shadow:0 10px 26px rgba(57,47,49,.04)}.content-card{background:transparent;border:0;box-shadow:none;color:#f6e8b8;text-align:center;padding:0}.content-thumb,.mission-thumb{position:relative;min-height:290px;border-radius:13px;overflow:hidden;background:linear-gradient(135deg,#f6d48a,var(--green));display:flex;align-items:end;padding:22px;color:#fff}.content-thumb:before,.mission-thumb:before{content:"";position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.62),rgba(0,0,0,.05)),repeating-linear-gradient(135deg,rgba(255,255,255,.18) 0 2px,transparent 2px 16px)}.content-thumb.blue{background:linear-gradient(135deg,#163c95,#0b94bf)}.content-thumb.photo{background:linear-gradient(135deg,#203c39,#d77d4b)}.content-thumb .inside,.mission-thumb .inside{position:relative;z-index:1}.content-card h3{font-size:15px;margin:12px 0 4px;color:#f6e8b8}.insta{display:grid;place-items:center;margin-bottom:26px}.seal{width:66px;height:66px;margin-bottom:10px}.missions{overflow:hidden}.mission-rail{display:grid;grid-template-columns:repeat(3,minmax(290px,1fr));gap:22px}.mission-thumb{min-height:330px}.mission-thumb.one{background:linear-gradient(135deg,#57463e,var(--green))}.mission-thumb.two{background:linear-gradient(135deg,#2f2333,var(--orange))}.mission-thumb.three{background:linear-gradient(135deg,#1f4d7d,var(--green))}.mission-thumb h3{margin:0;font-size:23px;text-shadow:0 2px 10px rgba(0,0,0,.4)}.events-empty{text-align:center;color:#888;padding:48px 0}.donation-band{background:var(--green);padding:56px 0}.donation-card{width:min(980px,calc(100% - 36px));margin:auto;border-radius:28px;background:var(--cream);display:grid;grid-template-columns:1fr 330px;align-items:center;gap:20px;padding:54px 70px;overflow:hidden}.phone-art{height:260px;border-radius:42px;background:#0b2f5b;padding:16px;border:10px solid #111;box-shadow:0 20px 60px rgba(0,0,0,.25);transform:rotate(-3deg)}.phone-art:before{content:"";display:block;height:100%;border-radius:28px;background:linear-gradient(#e9f4ff 0 28%,#104b85 28%);box-shadow:inset 0 0 0 1px rgba(255,255,255,.5)}.form{display:grid;gap:12px}.form.two{grid-template-columns:repeat(2,minmax(0,1fr))}.field{display:grid;gap:6px}.field.full{grid-column:1/-1}label{font-size:12px;font-weight:800;color:#44504d}input,select,textarea{width:100%;border:1px solid #d9d2c6;border-radius:8px;padding:11px 12px;background:#fff;color:var(--ink)}textarea{min-height:116px}.notice{border:1px solid #99f6e4;background:#ecfdf5;color:#115e59;border-radius:8px;padding:12px 14px;margin:18px auto}.media{width:100%;margin-top:14px}.content{font-size:17px}.content p{margin:0 0 16px}.footer{background:var(--green-dark);color:#d6eee9}.footer-main{padding:58px 0;display:grid;grid-template-columns:1.2fr 1fr 1fr;gap:44px}.footer-mark{width:84px;height:84px;margin-bottom:14px}.social{display:flex;gap:8px}.social i{display:grid;place-items:center;width:28px;height:28px;border-radius:999px;background:var(--orange);font-style:normal;font-size:12px}.footer-bottom{background:var(--green);color:#d6eee9;font-size:12px;padding:14px 0}.footer-bottom .wrap{display:flex;justify-content:space-between;gap:16px}.card h3{margin:0 0 8px;font-size:19px}.meta{font-size:13px;color:#8b817d}@media(max-width:850px){.nav{height:auto;align-items:flex-start;padding:14px 0;flex-direction:column}.links{gap:12px}.hero{min-height:360px}.hero-slide{min-height:360px}.anniversary{gap:10px;flex-wrap:wrap}.anniversary small{text-align:center;max-width:none;width:100%}.intro-grid,.grid,.form.two,.donation-card,.footer-main{grid-template-columns:1fr}.mission-rail{display:flex;overflow:auto;padding-bottom:8px}.mission-thumb{min-width:290px}.section.deep{border-radius:24px}.donation-card{padding:32px}.phone-art{height:220px}.footer-bottom .wrap{flex-direction:column}.links .optional{display:none}}
        .brand-logo{width:34px;height:34px;border-radius:999px;object-fit:cover;background:#fff}.footer-logo{width:84px;height:84px;border-radius:999px;object-fit:cover;background:#fff;margin-bottom:14px}
        .hero.is-slider .hero-slider{display:flex;width:calc(var(--slide-count) * 100%);animation:heroRun var(--slide-duration,21s) linear infinite;will-change:transform}.hero.is-slider .hero-slide{display:block;width:calc(100% / var(--slide-count));flex:0 0 calc(100% / var(--slide-count));animation:none}.hero:not(.is-slider) .hero-slide{display:block}.hero:hover .hero-slider{animation-play-state:paused}@keyframes heroRun{0%{transform:translateX(0)}100%{transform:translateX(calc(-100% + (100% / var(--slide-count))))}}
    </style>
</head>
<body>
    <header class="top">
        <nav class="wrap nav">
            <a class="brand" href="{{ route('public.home') }}">
                @if ($logoImage)
                    <img class="brand-logo" src="{{ $logoImage }}" alt="{{ $brandName }}">
                @else
                    <span class="brand-mark">{{ $logoMark }}</span>
                @endif
                {{ $brandName }}
            </a>
            <div class="links">
                <a href="{{ route('public.home') }}">Home</a>
                <a class="optional" href="{{ route('public.pages.show', 'sobre') }}">Sobre nos</a>
                <a href="{{ route('public.events') }}">Agenda</a>
                <a href="{{ route('public.sermons') }}">Pregacoes</a>
                <a href="{{ route('public.blog') }}">Blog</a>
                @foreach ($menuPages ?? [] as $menuPage)
                    @if ($menuPage->slug !== 'sobre')
                        <a href="{{ route('public.pages.show', $menuPage->slug) }}">{{ $menuPage->menu_label ?: $menuPage->title }}</a>
                    @endif
                @endforeach
                <a class="button warm" href="{{ route('public.home') }}#visitante">Seja um visitante</a>
            </div>
        </nav>
    </header>

    @if (session('status'))
        <div class="wrap notice">{{ session('status') }}</div>
    @endif

    {{ $slot }}

    <footer class="footer">
        @if ($theme['show_color_strip'] ?? false)
            <div class="tile-strip"></div>
        @endif
        <div class="wrap footer-main">
            <div>
                @if ($logoImage)
                    <img class="footer-logo" src="{{ $logoImage }}" alt="{{ $brandName }}">
                @else
                    <div class="footer-mark">{{ $logoMark }}</div>
                @endif
                <strong>{{ $brandName }}</strong>
                <p>Uma igreja para acolher, discipular e servir a cidade.</p>
            </div>
            <div>
                <h3>Endereco</h3>
                <p>Av. Principal, 1571<br>Belem, PA</p>
                <h3>Contatos</h3>
                <p>+55 (91) 98164-2424</p>
            </div>
            <div>
                <h3>Midias Digitais</h3>
                <div class="social"><i>ig</i><i>f</i><i>yt</i><i>x</i><i>wa</i></div>
                <h3>Boas Novas</h3>
                <p>Ao vivo e sob demanda</p>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="wrap"><span>Copyright &copy; {{ now()->year }} - {{ $brandName }}</span><span>Desenvolvido para SaaS Igreja</span></div>
        </div>
    </footer>
</body>
</html>
