<x-public-site.layout title="Agenda publica" :menu-pages="$menuPages">
    <section class="hero"><div class="wrap"><p class="eyebrow">Agenda</p><h1 class="h1">Proximos eventos e cultos</h1><p class="lead">Veja o que esta acontecendo na igreja e programe sua participacao.</p></div></section>
    <section class="section">
        <div class="wrap grid">
            @forelse ($events as $event)
                <article class="card">
                    <p class="meta">{{ $event->starts_at->format('d/m/Y H:i') }}</p>
                    <h3>{{ $event->title }}</h3>
                    <p class="muted">{{ $event->description }}</p>
                    <p class="meta">{{ $event->location?->name ?: 'Local a confirmar' }}</p>
                    @if ($event->requires_registration)
                        <p class="meta">Inscricao requerida</p>
                    @endif
                </article>
            @empty
                <div class="card"><h3>Agenda em preparacao</h3><p class="muted">Novos eventos aparecerao aqui quando forem publicados.</p></div>
            @endforelse
        </div>
    </section>
</x-public-site.layout>
