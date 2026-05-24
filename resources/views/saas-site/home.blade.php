@extends('saas-site.layout')

@section('title', 'SaaS Igreja - plataforma completa para igrejas')

@section('content')
<section class="hero">
    <div class="container hero-grid">
        <div>
            <div class="eyebrow">Gestão inteligente para igrejas</div>
            <h1>Sua igreja organizada, conectada e pronta para crescer.</h1>
            <p>Controle membros, células, eventos, financeiro, ensino, atendimento pastoral, site público, app, API e muito mais em uma plataforma pensada para o dia a dia da igreja.</p>
            <div class="hero-actions">
                <a class="btn btn-orange" href="{{ route('saas.plans') }}">Comece agora</a>
                <a class="btn btn-outline" href="#video" data-open-video>Ver apresentação</a>
            </div>
            <div class="trust"><span>Sem complicação</span><span>Multi-módulos</span><span>Suporte humano</span><span>API e webhooks</span></div>
        </div>
        <div class="product-shot" aria-label="Prévia da plataforma">
            <div class="browser">
                <div class="browser-bar"><i class="dot"></i><i class="dot"></i><i class="dot"></i></div>
                <div class="dashboard">
                    <div class="dash-card"><span>Membros ativos</span><strong>1.248</strong></div>
                    <div class="dash-card"><span>Check-ins hoje</span><strong>386</strong></div>
                    <div class="dash-card dash-wide"><strong>Visão geral</strong><div class="bars"><i style="height:32px"></i><i style="height:58px"></i><i style="height:44px"></i><i style="height:75px"></i><i style="height:62px"></i><i style="height:90px"></i></div></div>
                </div>
            </div>
            <div class="phone"><div class="phone-screen"><div class="app-line"></div><div class="app-line"></div><div class="app-line"></div><div class="app-line"></div><div class="app-line"></div></div></div>
        </div>
    </div>
</section>

<section id="recursos">
    <div class="container">
        <div class="section-title">
            <div class="eyebrow">Tudo em um só lugar</div>
            <h2>Uma plataforma para a rotina completa da igreja</h2>
            <p>Do primeiro contato do visitante ao relatório de liderança, o SaaS Igreja centraliza dados e reduz tarefas manuais.</p>
        </div>
        <div class="features">
            <div class="feature"><div class="icon">1</div><h3>Gestão completa</h3><p>Membros, visitantes, grupos, ministérios, voluntários e históricos sempre acessíveis.</p></div>
            <div class="feature"><div class="icon">2</div><h3>Mobile e check-in</h3><p>Check-in universal com QR Code, app, geofence e sincronização offline por dispositivo.</p></div>
            <div class="feature"><div class="icon">3</div><h3>Site e comunicação</h3><p>Editor visual, blog, formulários, transmissão ao vivo, chat e automações para líderes.</p></div>
        </div>
    </div>
</section>

<section id="acessos" class="access-section">
    <div class="container">
        <div class="section-title">
            <div class="eyebrow">Autenticação e permissões</div>
            <h2>Controle de acesso para uma operação multiigrejas</h2>
            <p>Cada igreja, congregação, usuário e departamento acessa somente o que precisa, com segurança e rastreabilidade para a liderança.</p>
        </div>
        <div class="access-grid">
            <article class="access-card">
                <div class="icon">A</div>
                <h3>Multiigrejas multi-tenant</h3>
                <p>Separe dados por igreja, sede, congregação ou unidade. Cada ambiente mantém seus próprios membros, eventos, finanças, site público e configurações.</p>
                <div class="access-list">
                    <span>Ambientes isolados por igreja</span>
                    <span>Identidade visual e domínio por unidade</span>
                    <span>Administração central com visão consolidada</span>
                </div>
            </article>
            <article class="access-card">
                <div class="icon">U</div>
                <h3>Multiusuários com permissões</h3>
                <p>Crie perfis para secretaria, tesouraria, pastores, líderes, voluntários e equipe de comunicação, limitando telas e ações por função.</p>
                <div class="access-list">
                    <span>Perfis e papéis por departamento</span>
                    <span>Acesso restrito a dados sensíveis</span>
                    <span>Histórico de ações administrativas</span>
                </div>
            </article>
        </div>
    </div>
</section>

<section id="paineis" class="panel-section">
    <div class="container">
        <div class="section-title">
            <div class="eyebrow">Painéis por departamento</div>
            <h2>Áreas separadas para cada equipe trabalhar melhor</h2>
            <p>O sistema organiza o trabalho por responsabilidade, sem misturar financeiro, cuidado pastoral, gestão administrativa e departamentos ministeriais.</p>
        </div>
        <div class="panel-grid">
            <article class="panel-card panel-admin">
                <div>
                    <strong>Administrativo</strong>
                    <h3>Gestão total da igreja</h3>
                    <p>Membros, visitantes, documentos, agenda, usuários, configurações, relatórios gerais e acompanhamento da operação.</p>
                </div>
            </article>
            <article class="panel-card panel-finance">
                <div>
                    <strong>Financeiro</strong>
                    <h3>Receitas, despesas e contas</h3>
                    <p>Dízimos, ofertas, fundos, conciliação, recibos, metas, categorias e prestação de contas com acesso restrito.</p>
                </div>
            </article>
            <article class="panel-card panel-pastoral">
                <div>
                    <strong>Pastoral</strong>
                    <h3>Cuidado e acompanhamento</h3>
                    <p>Atendimentos, visitas, aconselhamento, alertas, histórico pastoral e demandas sensíveis protegidas por permissão.</p>
                </div>
            </article>
            <article class="panel-card panel-departments">
                <div>
                    <strong>Departamentos</strong>
                    <h3>Ministérios e líderes</h3>
                    <p>Células, ensino, eventos, voluntários, comunicação, crianças, patrimônio, social e relatórios por área.</p>
                </div>
            </article>
        </div>
    </div>
</section>

<section id="video" class="dark">
    <div class="container">
        <div class="section-title">
            <h2>Vídeo de apresentação</h2>
            <p>Veja como uma igreja pode sair de planilhas soltas para uma operação integrada em poucos minutos.</p>
            <a class="btn btn-orange" href="#video" data-open-video>Assistir agora</a>
            <a class="btn btn-outline" href="{{ route('saas.support') }}" style="margin-left:10px">Solicitar demonstração</a>
        </div>
    </div>
</section>

<dialog class="video-modal" id="video-modal" aria-labelledby="video-title">
    <div class="modal-head">
        <h3 id="video-title">Apresentação SaaS Igreja</h3>
        <button class="modal-close" type="button" data-close-video aria-label="Fechar">×</button>
    </div>
    <div class="video-frame">
        <div>
            <h2 style="margin-top:0">Fluxo completo em poucos minutos</h2>
            <p>Cadastro de membros, eventos com QR Code, financeiro, comunicação, site público, app e relatórios funcionando juntos para reduzir tarefas manuais.</p>
            <a class="btn btn-orange" href="{{ route('saas.support') }}">Quero uma demonstração</a>
        </div>
    </div>
</dialog>

<section class="audience">
    <div class="container">
        <div class="section-title">
            <h2>Escolha a cor da sua igreja</h2>
            <p>Personalize site, app e identidade visual para combinar com a sua comunidade.</p>
        </div>
        <div class="who">
            <button class="theme-option" type="button" style="background:#166534" data-theme-option="green">Verde</button>
            <button class="theme-option" type="button" style="background:#b91c1c" data-theme-option="red">Vermelho</button>
            <button class="theme-option" type="button" style="background:#7c3aed" data-theme-option="purple">Roxo</button>
            <button class="theme-option" type="button" style="background:#0f766e" data-theme-option="teal">Teal</button>
            <button class="theme-option" type="button" style="background:#ea580c" data-theme-option="orange">Laranja</button>
        </div>
    </div>
</section>

<section class="modules">
    <div class="container">
        <div class="section-title">
            <div class="eyebrow">Módulos</div>
            <h2>Quais módulos tem na plataforma?</h2>
        </div>
        <div class="module-grid">
            @foreach ($modules as $module)
                <article class="module">
                    <div class="icon">{{ $loop->iteration }}</div>
                    <h3>{{ $module['title'] }}</h3>
                    <p>{{ $module['text'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section>
    <div class="container split">
        <div>
            <div class="eyebrow">Controle de membros</div>
            <h2>Cadastro vivo, histórico organizado e cuidado mais próximo</h2>
            <p style="color:var(--muted);line-height:1.8">Acompanhe membros, visitantes, famílias, ministérios, permissões, tags, documentos e interações em uma visão simples para secretaria e liderança.</p>
            <a class="btn btn-orange" href="{{ route('saas.plans') }}">Conhecer planos</a>
        </div>
        <div class="screen-pair"><div class="device one"><div class="mini-head"></div><div class="mini-row"></div><div class="mini-row"></div><div class="mini-row"></div><div class="mini-row"></div></div><div class="device two"><div class="mini-head"></div><div class="mini-row"></div><div class="mini-row"></div><div class="mini-row"></div></div></div>
    </div>
</section>

<section style="background:#f3f5f7">
    <div class="container split">
        <div class="screen-pair"><div class="device one"><div class="mini-head" style="background:linear-gradient(90deg,#16a34a,#8bd450)"></div><div class="mini-row"></div><div class="mini-row"></div><div class="mini-row"></div></div><div class="device two"><div class="mini-head" style="background:linear-gradient(90deg,#f97316,#facc15)"></div><div class="mini-row"></div><div class="mini-row"></div><div class="mini-row"></div></div></div>
        <div>
            <div class="eyebrow">Grupos e células</div>
            <h2>Relatórios para líderes e acompanhamento de crescimento</h2>
            <p style="color:var(--muted);line-height:1.8">Crie células, acompanhe presença, organize líderes, veja multiplicações e mantenha a equipe alinhada.</p>
        </div>
    </div>
</section>

<section class="band">
    <div class="container split">
        <div>
            <h2>Acesse também pelo computador</h2>
            <p>Painel administrativo completo para secretaria, financeiro, líderes, ministérios e comunicação.</p>
        </div>
        <a class="btn btn-orange" href="/admin">Entrar no sistema</a>
    </div>
</section>

<section>
    <div class="container">
        <div class="section-title">
            <div class="eyebrow">Conteúdo</div>
            <h2>Últimos artigos do blog</h2>
        </div>
        <div class="blog-grid">
            @foreach ($posts as $post)
                <article class="post">
                    <img src="{{ $post['image'] }}" alt="">
                    <div class="post-body"><span class="eyebrow">{{ $post['category'] }}</span><h3>{{ $post['title'] }}</h3><p>{{ $post['excerpt'] }}</p><a class="btn btn-outline" href="{{ route('saas.blog.show', $post['slug']) }}">Leia mais</a></div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
