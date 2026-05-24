<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SaaS Igreja')</title>
    <style>
        :root { --blue:#0b5f98; --blue-dark:#12324a; --orange:#ff8a00; --green:#20b56b; --ink:#17233a; --muted:#687386; --soft:#eef7fb; --cream:#fff4e8; --purple:#8b5cf6; --theme-gradient:linear-gradient(90deg, var(--blue), #57b5f5); }
        body[data-theme="green"] { --blue:#166534; --blue-dark:#123820; --orange:#20b56b; --soft:#effbf3; --theme-gradient:linear-gradient(90deg,#166534,#8bd450); }
        body[data-theme="red"] { --blue:#b91c1c; --blue-dark:#461414; --orange:#f97316; --soft:#fff1f2; --theme-gradient:linear-gradient(90deg,#b91c1c,#fb7185); }
        body[data-theme="purple"] { --blue:#7c3aed; --blue-dark:#33205f; --orange:#ff8a00; --soft:#f5f3ff; --theme-gradient:linear-gradient(90deg,#7c3aed,#c084fc); }
        body[data-theme="teal"] { --blue:#0f766e; --blue-dark:#123d3a; --orange:#14b8a6; --soft:#ecfeff; --theme-gradient:linear-gradient(90deg,#0f766e,#2dd4bf); }
        body[data-theme="orange"] { --blue:#ea580c; --blue-dark:#4a2412; --orange:#f97316; --soft:#fff7ed; --theme-gradient:linear-gradient(90deg,#ea580c,#facc15); }
        * { box-sizing: border-box; }
        body { margin:0; font-family: Inter, Arial, sans-serif; color:var(--ink); background:#fff; }
        a { color:inherit; text-decoration:none; }
        .container { width:min(1180px, calc(100% - 40px)); margin:0 auto; }
        .topbar { position:sticky; top:0; z-index:20; background:rgba(255,255,255,.94); backdrop-filter: blur(16px); border-bottom:1px solid #e8edf3; }
        .nav { height:76px; display:flex; align-items:center; justify-content:space-between; gap:28px; }
        .brand { display:flex; align-items:center; gap:12px; font-weight:900; font-size:24px; color:var(--blue-dark); }
        .brand-mark { width:42px; height:42px; border-radius:13px; display:grid; place-items:center; color:#fff; background:linear-gradient(145deg, var(--blue), #2b95d6); box-shadow: inset 0 -8px 0 rgba(255,138,0,.88); font-weight:900; }
        .links { display:flex; align-items:center; gap:24px; font-weight:700; font-size:14px; color:#405069; }
        .nav-actions { display:flex; align-items:center; gap:10px; }
        .menu-toggle { display:none; width:44px; height:44px; border-radius:8px; border:1px solid #cbd8e6; background:#fff; color:var(--blue-dark); font-weight:900; cursor:pointer; }
        .btn { display:inline-flex; align-items:center; justify-content:center; gap:8px; border-radius:8px; min-height:44px; padding:0 18px; font-weight:900; border:1px solid transparent; cursor:pointer; }
        .btn-orange { background:var(--orange); color:#fff; box-shadow:0 10px 22px rgba(255,138,0,.25); }
        .btn-blue { background:var(--blue); color:#fff; }
        .btn-outline { border-color:#cbd8e6; color:var(--blue-dark); background:#fff; }
        .hero { min-height:680px; display:flex; align-items:center; color:#fff; background:linear-gradient(90deg, rgba(6,43,78,.9), rgba(16,98,158,.72)), url('https://picsum.photos/seed/saas-igreja-hero/1800/1000') center/cover; overflow:hidden; }
        .hero-grid { display:grid; grid-template-columns:1.02fr .98fr; align-items:center; gap:50px; padding:80px 0; }
        .eyebrow { color:#ffd561; font-weight:900; letter-spacing:.08em; text-transform:uppercase; font-size:12px; }
        h1 { font-size:56px; line-height:1.02; margin:16px 0 18px; letter-spacing:-1px; }
        .hero p { font-size:20px; line-height:1.65; color:rgba(255,255,255,.86); max-width:620px; }
        .hero-actions { display:flex; flex-wrap:wrap; gap:14px; margin-top:28px; }
        .trust { display:flex; gap:20px; flex-wrap:wrap; margin-top:28px; color:#dceeff; font-weight:700; font-size:13px; }
        .product-shot { position:relative; min-height:390px; }
        .browser { position:absolute; right:0; top:10px; width:92%; border-radius:18px; background:#fff; box-shadow:0 30px 80px rgba(0,0,0,.35); overflow:hidden; color:var(--ink); }
        .browser-bar { height:34px; background:#eef3f8; display:flex; align-items:center; gap:7px; padding:0 14px; }
        .dot { width:9px; height:9px; border-radius:50%; background:#ff6b6b; } .dot:nth-child(2){background:#ffc145}.dot:nth-child(3){background:#2ecc71}
        .dashboard { padding:18px; display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        .dash-card { min-height:92px; border-radius:12px; background:#f7fafc; border:1px solid #e9eef5; padding:14px; }
        .dash-card strong { display:block; font-size:26px; color:var(--blue); }
        .dash-wide { grid-column:1/-1; height:140px; background:linear-gradient(135deg, #fff, #eaf6ff); position:relative; overflow:hidden; }
        .bars { position:absolute; inset:auto 18px 18px; display:flex; align-items:end; gap:9px; height:80px; }
        .bars i { width:34px; background:var(--orange); border-radius:8px 8px 0 0; }
        .phone { position:absolute; left:0; bottom:0; width:170px; height:330px; border-radius:30px; background:#111827; padding:10px; box-shadow:0 28px 65px rgba(0,0,0,.42); }
        .phone-screen { height:100%; border-radius:22px; background:linear-gradient(#f04b3c 0 28%, #fff 28%); padding:22px 14px; }
        .app-line { height:10px; border-radius:8px; background:#e5e7eb; margin:14px 0; }
        section { padding:80px 0; }
        .section-title { text-align:center; max-width:760px; margin:0 auto 42px; }
        .section-title h2 { font-size:38px; margin:8px 0 12px; letter-spacing:-.5px; }
        .section-title p { color:var(--muted); line-height:1.7; font-size:17px; }
        .features { display:grid; grid-template-columns:repeat(3, 1fr); gap:18px; }
        .feature { background:#fff; border:1px solid #e5ecf4; border-radius:14px; padding:24px; box-shadow:0 14px 35px rgba(25,49,80,.06); }
        .icon { width:42px; height:42px; border-radius:12px; display:grid; place-items:center; color:#fff; background:linear-gradient(145deg, var(--blue), #4eb6f5); font-weight:900; margin-bottom:16px; }
        .feature h3 { margin:0 0 8px; font-size:19px; }
        .feature p { color:var(--muted); line-height:1.65; margin:0; }
        .access-section { background:#f8fbfd; }
        .access-grid { display:grid; grid-template-columns:repeat(2, 1fr); gap:18px; }
        .access-card { background:#fff; border:1px solid #dfe8f2; border-radius:12px; padding:28px; box-shadow:0 14px 35px rgba(24,42,64,.06); }
        .access-card h3 { margin:0 0 10px; font-size:23px; color:var(--blue-dark); }
        .access-card p { color:var(--muted); line-height:1.7; margin:0; }
        .access-list { display:grid; gap:12px; margin-top:22px; }
        .access-list span { display:flex; align-items:center; gap:10px; color:#405069; font-weight:800; }
        .access-list span::before { content:""; width:10px; height:10px; border-radius:50%; background:var(--orange); box-shadow:0 0 0 5px rgba(255,138,0,.12); }
        .panel-section { background:#fff; }
        .panel-grid { display:grid; grid-template-columns:repeat(4, 1fr); gap:18px; }
        .panel-card { min-height:230px; border-radius:12px; padding:24px; color:#fff; display:flex; flex-direction:column; justify-content:space-between; overflow:hidden; position:relative; }
        .panel-card::after { content:""; position:absolute; width:140px; height:140px; right:-55px; bottom:-55px; border-radius:50%; background:rgba(255,255,255,.18); }
        .panel-card h3 { margin:0 0 10px; font-size:22px; position:relative; z-index:1; }
        .panel-card p { margin:0; line-height:1.65; color:rgba(255,255,255,.86); position:relative; z-index:1; }
        .panel-card strong { position:relative; z-index:1; font-size:13px; text-transform:uppercase; letter-spacing:.08em; color:#ffe7ba; }
        .panel-admin { background:linear-gradient(145deg,#12324a,#0b5f98); }
        .panel-finance { background:linear-gradient(145deg,#14532d,#20b56b); }
        .panel-pastoral { background:linear-gradient(145deg,#581c87,#8b5cf6); }
        .panel-departments { background:linear-gradient(145deg,#9a3412,#ff8a00); }
        .dark { background:#1f2528; color:#fff; text-align:center; }
        .dark p { color:#cbd5df; }
        .audience { background:linear-gradient(180deg, #133b53, #0f6dad); color:#fff; }
        .who { display:grid; grid-template-columns:repeat(5,1fr); gap:10px; }
        .who div { border:1px solid rgba(255,255,255,.2); background:rgba(255,255,255,.1); padding:18px; border-radius:10px; font-weight:900; text-align:center; }
        .modules { background:var(--cream); }
        .module-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:18px; }
        .module { background:#fff; border-radius:10px; border:1px solid #f2dac6; padding:22px; min-height:150px; }
        .split { display:grid; grid-template-columns:1fr 1fr; gap:70px; align-items:center; }
        .screen-pair { min-height:340px; position:relative; }
        .device { position:absolute; width:250px; border-radius:22px; background:#fff; border:1px solid #dce4ef; box-shadow:0 24px 65px rgba(15,32,58,.16); padding:16px; }
        .device.one { left:0; top:30px; } .device.two { right:0; bottom:0; }
        .mini-head { height:48px; border-radius:12px; background:var(--theme-gradient); margin-bottom:14px; }
        .mini-row { height:12px; background:#e9eef5; border-radius:9px; margin:12px 0; }
        .band { background:linear-gradient(115deg, #b656a1, #7c3de2); color:#fff; }
        .plans { display:grid; grid-template-columns:repeat(4,1fr); gap:18px; align-items:start; }
        .plan { border:1px solid #e5edf5; border-radius:14px; padding:24px; background:#fff; box-shadow:0 14px 35px rgba(24,42,64,.06); }
        .plan.featured { border-color:var(--orange); transform:translateY(-10px); box-shadow:0 22px 60px rgba(255,138,0,.18); }
        .price { font-size:42px; color:var(--blue); font-weight:900; margin:12px 0 2px; }
        .plan ul { padding:0; margin:20px 0 0; list-style:none; }
        .plan li { border-top:1px solid #eef2f7; padding:10px 0; color:#516071; font-size:14px; }
        .blog-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:22px; }
        .post { background:#fff; border:1px solid #e5edf5; border-radius:12px; overflow:hidden; box-shadow:0 14px 35px rgba(24,42,64,.06); }
        .post img { width:100%; height:190px; object-fit:cover; }
        .post-body { padding:20px; }
        .post h3 { margin:8px 0 10px; font-size:20px; }
        .post p { color:var(--muted); line-height:1.6; }
        .help-hero { background:#0b5f98; color:#fff; text-align:center; padding:120px 0; }
        .help-search { width:min(620px, 100%); margin:28px auto 0; background:#fff; border-radius:999px; display:flex; align-items:center; padding:8px 18px; color:#64748b; }
        .help-search input { flex:1; border:0; outline:0; min-height:42px; font-size:16px; }
        .help-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:34px; }
        .help-card h3 { color:var(--orange); text-transform:uppercase; border-bottom:1px solid #d8e2ec; padding-bottom:12px; }
        .help-card ul { list-style:none; padding:0; margin:0; }
        .help-card li { padding:9px 0; color:#435066; }
        .support-wrap { background:#f4f7fa; padding:56px 0; }
        .support-card { background:#fff; border:1px solid #dce4ed; border-radius:12px; padding:42px; max-width:920px; margin:0 auto; }
        .form-grid { display:grid; grid-template-columns:190px 1fr; gap:18px; align-items:center; }
        input, textarea { width:100%; border:1px solid #cbd5e1; border-radius:8px; min-height:48px; padding:12px 14px; font:inherit; }
        textarea { min-height:190px; resize:vertical; }
        footer { background:#172b3d; color:#d7e2eb; padding:54px 0 28px; }
        .footer-grid { display:grid; grid-template-columns:2fr 1fr 1fr 1fr; gap:32px; }
        footer a { display:block; margin:10px 0; color:#d7e2eb; }
        .copyright { border-top:1px solid rgba(255,255,255,.12); margin-top:34px; padding-top:22px; text-align:center; color:#a8b6c2; }
        .float-whats { position:fixed; right:22px; bottom:22px; width:54px; height:54px; border-radius:50%; background:#25d366; color:#fff; display:grid; place-items:center; font-weight:900; box-shadow:0 15px 35px rgba(0,0,0,.2); z-index:30; }
        .theme-option { border:0; color:#fff; padding:18px; border-radius:10px; font-weight:900; text-align:center; cursor:pointer; }
        .theme-option.is-active { outline:3px solid rgba(255,255,255,.9); outline-offset:3px; }
        .video-modal { width:min(860px, calc(100% - 28px)); border:0; border-radius:14px; padding:0; box-shadow:0 30px 90px rgba(0,0,0,.35); }
        .video-modal::backdrop { background:rgba(8,18,30,.68); backdrop-filter:blur(4px); }
        .modal-head { display:flex; align-items:center; justify-content:space-between; gap:14px; padding:18px 20px; border-bottom:1px solid #e5edf5; }
        .modal-head h3 { margin:0; }
        .modal-close { width:38px; height:38px; border-radius:8px; border:1px solid #d8e2ec; background:#fff; cursor:pointer; font-size:22px; line-height:1; }
        .video-frame { aspect-ratio:16/9; background:linear-gradient(135deg,#10283e,#0b5f98); color:#fff; display:grid; place-items:center; text-align:center; padding:32px; }
        .video-frame p { max-width:560px; line-height:1.7; color:#eaf6ff; }
        .empty-state { display:none; grid-column:1/-1; text-align:center; color:var(--muted); padding:26px; border:1px dashed #cbd8e6; border-radius:10px; }
        @media (max-width: 900px) {
            .nav { height:auto; min-height:70px; flex-wrap:wrap; padding:12px 0; }
            .menu-toggle { display:grid; place-items:center; }
            .links { display:none; order:3; width:100%; flex-direction:column; align-items:flex-start; gap:0; padding:8px 0 4px; }
            .links a { width:100%; padding:13px 0; border-top:1px solid #e8edf3; }
            .topbar.is-open .links { display:flex; }
            .nav-actions .btn { min-height:40px; padding:0 12px; font-size:13px; }
            .hero-grid, .split, .footer-grid { grid-template-columns:1fr; }
            h1 { font-size:40px; }
            .features, .module-grid, .blog-grid, .plans, .help-grid, .who, .access-grid, .panel-grid { grid-template-columns:1fr; }
            .product-shot { min-height:500px; }
            .form-grid { grid-template-columns:1fr; }
        }
    </style>
</head>
<body>
<header class="topbar">
    <div class="container nav">
        <a class="brand" href="{{ route('saas.home') }}"><span class="brand-mark">S</span> SaaS Igreja</a>
        <button class="menu-toggle" type="button" aria-label="Abrir menu" aria-expanded="false">☰</button>
        <nav class="links">
            <a href="{{ route('saas.home') }}#recursos">Recursos</a>
            <a href="{{ route('saas.home') }}#acessos">Acessos</a>
            <a href="{{ route('saas.home') }}#paineis">Painéis</a>
            <a href="{{ route('saas.plans') }}">Preços</a>
            <a href="{{ route('saas.help') }}">Ajuda</a>
            <a href="{{ route('saas.blog') }}">Blog</a>
            <a href="{{ route('saas.support') }}">Fale conosco</a>
        </nav>
        <div class="nav-actions">
            <a class="btn btn-outline" href="/admin">Acesso ao sistema</a>
        </div>
    </div>
</header>

@yield('content')

<footer>
    <div class="container footer-grid">
        <div>
            <div class="brand" style="color:#fff"><span class="brand-mark">S</span> SaaS Igreja</div>
            <p style="line-height:1.7;color:#b7c6d4;max-width:420px">Uma plataforma completa para igrejas organizarem pessoas, eventos, finanças, ensino, comunicação e presença digital.</p>
        </div>
        <div><strong>Recursos</strong><a href="{{ route('saas.home') }}#recursos">Módulos</a><a href="{{ route('saas.plans') }}">Planos</a><a href="{{ route('api.docs.ui') }}">API</a></div>
        <div><strong>Suporte</strong><a href="{{ route('saas.help') }}">Central de ajuda</a><a href="{{ route('saas.support') }}">Abrir chamado</a><a href="#">WhatsApp</a></div>
        <div><strong>Legal</strong><a href="#">Termos de uso</a><a href="#">Privacidade</a><a href="#">Cookies</a></div>
    </div>
    <div class="container copyright">Copyright © {{ date('Y') }} SaaS Igreja. Todos os direitos reservados.</div>
</footer>
<a class="float-whats" href="{{ route('saas.support') }}" aria-label="Abrir suporte">?</a>
<script>
    const savedTheme = localStorage.getItem('saas-igreja-theme');
    if (savedTheme) {
        document.body.dataset.theme = savedTheme;
    }

    document.querySelector('.menu-toggle')?.addEventListener('click', (event) => {
        const header = document.querySelector('.topbar');
        const isOpen = header.classList.toggle('is-open');
        event.currentTarget.setAttribute('aria-expanded', String(isOpen));
    });

    document.querySelectorAll('[data-theme-option]').forEach((button) => {
        const theme = button.dataset.themeOption;

        if ((document.body.dataset.theme || 'blue') === theme) {
            button.classList.add('is-active');
        }

        button.addEventListener('click', () => {
            document.body.dataset.theme = theme;
            localStorage.setItem('saas-igreja-theme', theme);
            document.querySelectorAll('[data-theme-option]').forEach((item) => item.classList.remove('is-active'));
            button.classList.add('is-active');
        });
    });

    document.querySelectorAll('[data-open-video]').forEach((button) => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            document.querySelector('#video-modal')?.showModal();
        });
    });

    document.querySelectorAll('[data-close-video]').forEach((button) => {
        button.addEventListener('click', () => document.querySelector('#video-modal')?.close());
    });

    document.querySelector('[data-help-search]')?.addEventListener('input', (event) => {
        const term = event.target.value.toLocaleLowerCase('pt-BR').trim();
        let visibleCards = 0;

        document.querySelectorAll('[data-help-card]').forEach((card) => {
            const matches = card.textContent.toLocaleLowerCase('pt-BR').includes(term);
            card.style.display = matches ? '' : 'none';
            visibleCards += matches ? 1 : 0;
        });

        const emptyState = document.querySelector('[data-help-empty]');
        if (emptyState) {
            emptyState.style.display = visibleCards ? 'none' : 'block';
        }
    });
</script>
</body>
</html>
