@foreach ($blocks ?? [] as $block)
    @php($data = $block['data'] ?? [])
    @if (($block['type'] ?? null) === 'hero')
        <section class="hero">
            <div class="wrap">
                <p class="eyebrow">Bem-vindo</p>
                <h1 class="h1">{{ $data['heading'] ?? $page->title }}</h1>
                @if (filled($data['subheading'] ?? null))
                    <p class="lead">{{ $data['subheading'] }}</p>
                @endif
                @if (filled($data['button_label'] ?? null) && filled($data['button_url'] ?? null))
                    <div class="actions"><a class="button" href="{{ $data['button_url'] }}">{{ $data['button_label'] }}</a></div>
                @endif
            </div>
        </section>
    @elseif (($block['type'] ?? null) === 'text')
        <section class="section"><div class="wrap content">{!! $data['content'] ?? '' !!}</div></section>
    @elseif (($block['type'] ?? null) === 'cta')
        <section class="section soft"><div class="wrap panel">
            <h2>{{ $data['heading'] ?? '' }}</h2>
            @if (filled($data['body'] ?? null))<p class="muted">{{ $data['body'] }}</p>@endif
            @if (filled($data['button_label'] ?? null) && filled($data['button_url'] ?? null))
                <div class="actions"><a class="button" href="{{ $data['button_url'] }}">{{ $data['button_label'] }}</a></div>
            @endif
        </div></section>
    @endif
@endforeach
