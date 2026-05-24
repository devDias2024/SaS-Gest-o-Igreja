<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - {{ $form->title }}</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; background: #f6f4ef; color: #24212a; }
        main { width: min(1180px, calc(100% - 32px)); margin: 36px auto; }
        h1 { margin: 0 0 8px; font-size: clamp(2rem, 4vw, 3.2rem); line-height: 1; letter-spacing: 0; }
        h2 { margin: 0 0 18px; }
        p { color: #716b72; }
        .grid { display: grid; gap: 16px; }
        .cards { grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); margin: 28px 0; }
        .two { grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); }
        .card { background: #fff; border: 1px solid #e6e1d8; border-radius: 8px; padding: 22px; box-shadow: 0 16px 34px rgba(36, 33, 42, .06); }
        .metric { font-size: 2.2rem; font-weight: 900; color: #006b57; }
        .bar { height: 10px; background: #ebe7df; border-radius: 999px; overflow: hidden; margin-top: 8px; }
        .fill { height: 100%; background: #006b57; border-radius: inherit; }
        .row { display: flex; justify-content: space-between; gap: 16px; padding: 10px 0; border-bottom: 1px solid #eee9e1; }
        .row:last-child { border-bottom: 0; }
        a { color: #006b57; font-weight: 800; text-decoration: none; }
    </style>
</head>
<body>
<main>
    <a href="{{ url('/admin/process-forms/'.$form->id.'/edit') }}">Voltar para o formulario</a>
    <header>
        <h1>{{ $form->title }}</h1>
        <p>Dashboard de respostas e relatorio por pergunta.</p>
    </header>

    <section class="grid cards">
        <div class="card"><div class="metric">{{ $total }}</div><p>Total de respostas</p></div>
        <div class="card"><div class="metric">{{ $statusCounts['pending'] ?? 0 }}</div><p>Pendentes</p></div>
        <div class="card"><div class="metric">{{ $statusCounts['approved'] ?? 0 }}</div><p>Aprovadas</p></div>
        <div class="card"><div class="metric">{{ $statusCounts['completed'] ?? 0 }}</div><p>Concluidas</p></div>
    </section>

    <section class="grid two">
        <div class="card">
            <h2>Conversao por dia</h2>
            @forelse($dailyCounts as $day => $count)
                <div class="row"><span>{{ $day }}</span><strong>{{ $count }}</strong></div>
            @empty
                <p>Nenhuma resposta registrada ainda.</p>
            @endforelse
        </div>

        <div class="card">
            <h2>Status</h2>
            @foreach(['pending' => 'Pendente', 'approved' => 'Aprovado', 'completed' => 'Concluido', 'archived' => 'Arquivado'] as $status => $label)
                @php($count = $statusCounts[$status] ?? 0)
                <div class="row"><span>{{ $label }}</span><strong>{{ $count }}</strong></div>
                <div class="bar"><div class="fill" style="width: {{ $total > 0 ? min(100, ($count / $total) * 100) : 0 }}%"></div></div>
            @endforeach
        </div>
    </section>

    <section class="card" style="margin-top:16px">
        <h2>Relatorio por pergunta</h2>
        @forelse($questionReport as $question)
            <div style="padding:18px 0;border-top:1px solid #eee9e1">
                <strong>{{ $question['label'] }}</strong>
                <p>{{ $question['answered'] }} respondidas, {{ $question['empty'] }} vazias</p>
                @foreach($question['options'] as $answer => $count)
                    <div class="row"><span>{{ $answer }}</span><strong>{{ $count }}</strong></div>
                @endforeach
            </div>
        @empty
            <p>Nenhuma pergunta configurada.</p>
        @endforelse
    </section>
</main>
</body>
</html>
