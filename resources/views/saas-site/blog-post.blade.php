@extends('saas-site.layout')

@section('title', $post['title'].' - SaaS Igreja')

@section('content')
<section class="hero" style="min-height:420px">
    <div class="container section-title" style="color:#fff;margin:auto">
        <div class="eyebrow">{{ $post['category'] }}</div>
        <h1>{{ $post['title'] }}</h1>
        <p>{{ $post['excerpt'] }}</p>
    </div>
</section>

<section>
    <div class="container" style="max-width:900px">
        <img src="{{ $post['image'] }}" alt="" style="width:100%;height:360px;object-fit:cover;border-radius:12px;margin-bottom:34px">
        <p style="color:var(--muted);line-height:1.9;font-size:18px">O primeiro passo para organizar a igreja é reunir pessoas, rotinas e informações importantes em um fluxo simples. Quando membros, eventos, financeiro e comunicação trabalham juntos, a liderança ganha clareza e a equipe perde menos tempo com tarefas repetidas.</p>
        <p style="color:var(--muted);line-height:1.9;font-size:18px">Com o SaaS Igreja, cada módulo conversa com os demais: um visitante pode virar membro, uma inscrição pode gerar check-in, uma campanha pode alimentar relatórios e um formulário pode acionar automações. Isso cria uma operação mais leve para secretaria, líderes e voluntários.</p>
        <div style="margin-top:32px">
            <a class="btn btn-orange" href="{{ route('saas.support') }}">Falar com a equipe</a>
            <a class="btn btn-outline" href="{{ route('saas.blog') }}">Voltar ao blog</a>
        </div>
    </div>
</section>

<section style="background:var(--soft)">
    <div class="container">
        <div class="section-title">
            <div class="eyebrow">Continue lendo</div>
            <h2>Outros artigos</h2>
        </div>
        <div class="blog-grid">
            @foreach (array_slice($posts, 0, 3) as $related)
                <article class="post">
                    <img src="{{ $related['image'] }}" alt="">
                    <div class="post-body">
                        <span class="eyebrow">{{ $related['category'] }}</span>
                        <h3>{{ $related['title'] }}</h3>
                        <p>{{ $related['excerpt'] }}</p>
                        <a class="btn btn-outline" href="{{ route('saas.blog.show', $related['slug']) }}">Leia mais</a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
