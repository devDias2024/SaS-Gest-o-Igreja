<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Relatorio de demanda pastoral</title>
    <style>
        body { margin: 0; font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; background: #f6f4ef; color: #24212a; }
        main { width: min(960px, calc(100% - 32px)); margin: 36px auto; }
        h1 { margin: 0 0 8px; font-size: clamp(2rem, 4vw, 3.2rem); line-height: 1; letter-spacing: 0; }
        p { color: #716b72; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 16px; margin-top: 24px; }
        .card { background: #fff; border: 1px solid #e6e1d8; border-radius: 8px; padding: 22px; box-shadow: 0 16px 34px rgba(36, 33, 42, .06); }
        .row { display: flex; justify-content: space-between; gap: 16px; padding: 12px 0; border-bottom: 1px solid #eee9e1; }
        .row:last-child { border-bottom: 0; }
        a { color: #006b57; font-weight: 800; text-decoration: none; }
    </style>
</head>
<body>
<main>
    <a href="{{ url('/admin/pastoral-counseling-cases') }}">Voltar</a>
    <h1>Relatorio de demanda</h1>
    <p>Dados agregados sem identificacao do aconselhado.</p>
    <section class="grid">
        <div class="card">
            <h2>Assuntos recorrentes</h2>
            @forelse($subjects as $subject)
                <div class="row"><span>{{ $subject->main_subject }}</span><strong>{{ $subject->total }}</strong></div>
            @empty
                <p>Nenhum assunto registrado.</p>
            @endforelse
        </div>
        <div class="card">
            <h2>Status dos casos</h2>
            @forelse($statuses as $status)
                <div class="row"><span>{{ $status->status }}</span><strong>{{ $status->total }}</strong></div>
            @empty
                <p>Nenhum caso registrado.</p>
            @endforelse
        </div>
    </section>
</main>
</body>
</html>
