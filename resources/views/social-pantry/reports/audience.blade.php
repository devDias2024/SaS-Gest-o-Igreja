<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Relatorio publico atendido</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f6f7f9; color: #18202a; }
        main { max-width: 1120px; margin: 0 auto; padding: 32px 20px; }
        h1 { margin: 0 0 6px; font-size: 30px; }
        .muted { color: #667085; }
        .grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; margin: 24px 0; }
        .card { background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; padding: 18px; box-shadow: 0 10px 24px rgba(15, 23, 42, .06); }
        .value { font-size: 28px; font-weight: 800; color: #0f766e; }
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 14px; overflow: hidden; margin-top: 12px; }
        th, td { padding: 12px 14px; border-bottom: 1px solid #edf0f3; text-align: left; font-size: 14px; }
        th { background: #111827; color: #fff; }
        section { margin-top: 28px; }
        @media (max-width: 800px) { .grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    </style>
</head>
<body>
<main>
    <h1>Relatorio de publico atendido</h1>
    <div class="muted">Refeitorio, doacoes e despensa social</div>

    <div class="grid">
        <div class="card"><div class="muted">Refeicoes para membros</div><div class="value">{{ $mealTotals['members'] }}</div></div>
        <div class="card"><div class="muted">Refeicoes para comunidade</div><div class="value">{{ $mealTotals['community'] }}</div></div>
        <div class="card"><div class="muted">Voluntarios servidos</div><div class="value">{{ $mealTotals['volunteers'] }}</div></div>
        <div class="card"><div class="muted">Total de refeicoes</div><div class="value">{{ $mealTotals['total'] }}</div></div>
    </div>

    <div class="grid">
        <div class="card"><div class="muted">Familias membros</div><div class="value">{{ $distributionTotals['member_families'] }}</div></div>
        <div class="card"><div class="muted">Familias comunidade</div><div class="value">{{ $distributionTotals['community_families'] }}</div></div>
        <div class="card"><div class="muted">Pessoas em familias</div><div class="value">{{ $distributionTotals['people'] }}</div></div>
        <div class="card"><div class="muted">Familias atendidas</div><div class="value">{{ $distributionTotals['member_families'] + $distributionTotals['community_families'] }}</div></div>
    </div>

    <section>
        <h2>Itens perto do vencimento</h2>
        <table>
            <thead><tr><th>Item</th><th>Qtd.</th><th>Validade</th><th>Doador</th></tr></thead>
            <tbody>
            @forelse ($expiringItems as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ number_format((float) $item->quantity, 2, ',', '.') }} {{ $item->unit }}</td>
                    <td>{{ $item->expires_on?->format('d/m/Y') }}</td>
                    <td>{{ $item->donation?->donorMember?->full_name ?? $item->donation?->donor_name ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Nenhum item vencendo nos proximos 30 dias.</td></tr>
            @endforelse
            </tbody>
        </table>
    </section>

    <section>
        <h2>Ultimas distribuicoes</h2>
        <table>
            <thead><tr><th>Data</th><th>Beneficiario</th><th>Publico</th><th>Pessoas</th><th>Itens</th></tr></thead>
            <tbody>
            @forelse ($recentDistributions as $distribution)
                <tr>
                    <td>{{ $distribution->distributed_on?->format('d/m/Y') }}</td>
                    <td>{{ $distribution->member?->full_name ?? $distribution->beneficiary_name ?? '-' }}</td>
                    <td>{{ $distribution->audience_type === 'member' ? 'Membro' : 'Comunidade' }}</td>
                    <td>{{ $distribution->family_size ?? '-' }}</td>
                    <td>{{ $distribution->items->pluck('name')->join(', ') ?: '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="5">Nenhuma distribuicao registrada.</td></tr>
            @endforelse
            </tbody>
        </table>
    </section>
</main>
</body>
</html>
