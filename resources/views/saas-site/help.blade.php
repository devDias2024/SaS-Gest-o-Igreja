@extends('saas-site.layout')

@section('title', 'Central de ajuda - SaaS Igreja')

@section('content')
<section class="help-hero">
    <div class="container">
        <h1>Olá, como podemos te ajudar hoje?</h1>
        <div class="help-search"><input data-help-search placeholder="Buscar artigos, módulos e tutoriais"><strong>Ctrl K</strong></div>
    </div>
</section>
<section>
    <div class="container help-grid">
        @foreach ($categories as $title => $items)
            <article class="help-card" data-help-card>
                <h3>{{ $title }} <small>({{ count($items) }})</small></h3>
                <ul>
                    @foreach ($items as $item)
                        <li>□ {{ $item }}</li>
                    @endforeach
                </ul>
                <a style="color:var(--blue);font-weight:800;margin-top:12px;display:inline-block" href="{{ route('saas.support') }}">Abrir chamado →</a>
            </article>
        @endforeach
        <div class="empty-state" data-help-empty>Nenhum artigo encontrado. Abra um chamado e nossa equipe ajuda você.</div>
    </div>
</section>
@endsection
