<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $sermon->title }}</title>
    <style>
        body { margin: 0; font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; background: #111827; color: #f9fafb; }
        main { width: min(960px, calc(100% - 32px)); margin: 0 auto; padding: 32px 0; }
        .meta { color: #cbd5e1; margin: 8px 0 24px; }
        .player { background: #020617; border: 1px solid #334155; border-radius: 8px; overflow: hidden; }
        video, audio, iframe { display: block; width: 100%; }
        video, iframe { aspect-ratio: 16 / 9; height: auto; }
        audio { padding: 16px; box-sizing: border-box; }
        .controls { display: flex; flex-wrap: wrap; gap: 12px; align-items: center; padding: 16px; border-top: 1px solid #334155; }
        select, a.button { border: 1px solid #475569; border-radius: 6px; background: #1f2937; color: #f9fafb; padding: 8px 10px; text-decoration: none; }
        .summary { margin-top: 24px; line-height: 1.65; color: #e5e7eb; }
    </style>
</head>
<body>
    <main>
        <h1>{{ $sermon->title }}</h1>
        <div class="meta">
            {{ $sermon->preacher?->name ?? 'Pregador nao informado' }}
            @if ($sermon->preached_at)
                · {{ $sermon->preached_at->format('d/m/Y H:i') }}
            @endif
            @if ($sermon->category)
                · {{ $sermon->category->name }}
            @endif
            @if ($sermon->series)
                · {{ $sermon->series->title }}
            @endif
        </div>

        <div class="player">
            @if ($media && $media->source === 'upload' && $media->media_type === 'audio')
                <audio id="sermon-player" controls src="{{ $media->playback_url }}"></audio>
            @elseif ($media && $media->source === 'upload')
                <video id="sermon-player" controls src="{{ $media->playback_url }}"></video>
            @elseif ($media && $media->playback_url)
                <iframe src="{{ $media->playback_url }}" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
            @else
                <div style="padding: 24px;">Midia indisponivel.</div>
            @endif

            <div class="controls">
                <label for="speed">Velocidade</label>
                <select id="speed">
                    <option value="0.75">0.75x</option>
                    <option value="1" selected>1x</option>
                    <option value="1.25">1.25x</option>
                    <option value="1.5">1.5x</option>
                    <option value="2">2x</option>
                </select>

                @if ($media && $media->source === 'upload' && ($shareLink->allow_download || $sermon->allow_download || $media->allow_download))
                    <a class="button" href="{{ route('sermons.share.download', [$shareLink->token, $media]) }}">Download</a>
                @endif
            </div>
        </div>

        @if ($sermon->scripture_reference || $sermon->summary)
            <div class="summary">
                @if ($sermon->scripture_reference)
                    <strong>{{ $sermon->scripture_reference }}</strong>
                @endif
                @if ($sermon->summary)
                    <p>{{ $sermon->summary }}</p>
                @endif
            </div>
        @endif
    </main>

    <script>
        const player = document.getElementById('sermon-player');
        const speed = document.getElementById('speed');

        if (player && speed) {
            speed.addEventListener('change', () => {
                player.playbackRate = Number(speed.value);
            });
        }
    </script>
</body>
</html>
