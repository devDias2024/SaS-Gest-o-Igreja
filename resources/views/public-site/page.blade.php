<x-public-site.layout :title="$page->meta_title ?: $page->title" :description="$page->meta_description" :menu-pages="$menuPages">
    @if ($page->blocks)
        @include('public-site.partials.blocks', ['blocks' => $page->blocks, 'page' => $page])
    @else
        <section class="hero"><div class="wrap"><p class="eyebrow">Pagina</p><h1 class="h1">{{ $page->title }}</h1></div></section>
    @endif
</x-public-site.layout>
