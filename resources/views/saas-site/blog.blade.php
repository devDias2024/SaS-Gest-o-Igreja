@extends('saas-site.layout')

@section('title', 'Blog - SaaS Igreja')

@section('content')
<section style="background:var(--soft)">
    <div class="container">
        <div class="section-title">
            <h1>Blog SaaS Igreja</h1>
            <p>Conteúdos práticos sobre gestão, tecnologia e organização para igrejas.</p>
        </div>
        <div class="blog-grid">
            @foreach ($posts as $post)
                <article class="post">
                    <img src="{{ $post['image'] }}" alt="">
                    <div class="post-body">
                        <span class="eyebrow">{{ $post['category'] }}</span>
                        <h3>{{ $post['title'] }}</h3>
                        <p>{{ $post['excerpt'] }}</p>
                        <a class="btn btn-orange" href="{{ route('saas.blog.show', $post['slug']) }}">Leia mais</a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
