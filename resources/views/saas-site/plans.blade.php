@extends('saas-site.layout')

@section('title', 'Planos - SaaS Igreja')

@section('content')
<section class="hero" style="min-height:360px">
    <div class="container section-title" style="color:#fff;margin:auto">
        <h1>Conheça os planos SaaS Igreja</h1>
        <p>Escolha o plano ideal e comece a organizar sua igreja ainda hoje.</p>
    </div>
</section>
<section>
    <div class="container">
        <div class="plans">
            @foreach ($plans as $plan)
                <article class="plan {{ $plan['featured'] ? 'featured' : '' }}">
                    <h2>{{ $plan['name'] }}</h2>
                    <div class="price">{{ $plan['price'] }}</div>
                    <div style="color:var(--muted)">{{ $plan['note'] }}</div>
                    <ul>
                        @foreach ($plan['features'] as $feature)
                            <li>✓ {{ $feature }}</li>
                        @endforeach
                    </ul>
                    <a class="btn {{ $plan['featured'] ? 'btn-orange' : 'btn-outline' }}" href="{{ route('saas.support', ['plano' => $plan['name']]) }}" style="width:100%;margin-top:22px">Escolher {{ $plan['name'] }}</a>
                </article>
            @endforeach
        </div>
        <div style="text-align:center;margin-top:42px">
            <a class="btn btn-orange" href="{{ route('saas.support') }}">Comece no plano gratuito</a>
            <p style="color:var(--muted)">Precisa de mais limites? Fale com nossa equipe.</p>
        </div>
    </div>
</section>
@endsection
