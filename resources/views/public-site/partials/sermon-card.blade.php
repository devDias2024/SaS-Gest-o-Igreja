<article class="card">
    <p class="meta">{{ $sermon->preached_at?->format('d/m/Y') }} @if($sermon->preacher) &middot; {{ $sermon->preacher->name }} @endif</p>
    <h3>{{ $sermon->title }}</h3>
    <p class="muted">{{ $sermon->summary }}</p>
    @if ($sermon->primaryMedia?->playback_url)
        @if ($sermon->primaryMedia->media_type === 'audio')
            <audio class="media" controls src="{{ $sermon->primaryMedia->playback_url }}"></audio>
        @else
            <video class="media" controls src="{{ $sermon->primaryMedia->playback_url }}"></video>
        @endif
    @endif
</article>
