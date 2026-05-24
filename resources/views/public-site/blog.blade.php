<x-public-site.layout title="Blog institucional" :menu-pages="$menuPages">
    <section class="hero"><div class="wrap"><p class="eyebrow">Blog</p><h1 class="h1">Blog institucional</h1><p class="lead">Noticias, devocionais e comunicados da igreja.</p></div></section>
    <section class="section">
        <div class="wrap grid">
            @forelse ($posts as $post)
                <article class="card">
                    @if ($post->cover_image)<img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($post->cover_image) }}" alt="">@endif
                    <p class="meta">{{ $post->published_at?->format('d/m/Y') }} @if($post->category) · {{ $post->category }} @endif</p>
                    <h3><a href="{{ route('public.blog.show', $post->slug) }}">{{ $post->title }}</a></h3>
                    <p class="muted">{{ $post->excerpt }}</p>
                </article>
            @empty
                <div class="card"><h3>Nenhum post publicado</h3><p class="muted">Crie posts no painel administrativo.</p></div>
            @endforelse
        </div>
        <div class="wrap" style="margin-top:24px">{{ $posts->links() }}</div>
    </section>
</x-public-site.layout>
