<x-public-site.layout title="Arquivo de pregacoes" :menu-pages="$menuPages">
    <section class="hero"><div class="wrap"><p class="eyebrow">Mensagens</p><h1 class="h1">Arquivo de pregacoes</h1><p class="lead">Assista ou ouca as mensagens publicadas pela igreja.</p></div></section>
    <section class="section"><div class="wrap grid">
        @forelse ($sermons as $sermon)
            @include('public-site.partials.sermon-card', ['sermon' => $sermon])
        @empty
            <div class="card"><h3>Nenhuma pregacao publicada</h3><p class="muted">Publique pregacoes no modulo Biblioteca de Cultos.</p></div>
        @endforelse
    </div></section>
</x-public-site.layout>
