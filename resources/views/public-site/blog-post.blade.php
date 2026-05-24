<x-public-site.layout :title="$post->title" :description="$post->excerpt" :menu-pages="$menuPages">
    <section class="hero">
        <div class="wrap">
            <p class="eyebrow">{{ $post->category ?: 'Blog' }}</p>
            <h1 class="h1">{{ $post->title }}</h1>
            <p class="lead">{{ $post->excerpt }}</p>
        </div>
    </section>
    <section class="section">
        <article class="wrap content">
            @if ($post->cover_image)<img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($post->cover_image) }}" alt="" style="border-radius:8px;margin-bottom:24px">@endif
            {!! $post->content !!}
        </article>
    </section>
</x-public-site.layout>
