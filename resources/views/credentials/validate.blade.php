<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Validacao de credencial</title>
    <style>
        * { box-sizing: border-box; }
        body { background: #f3f4f6; color: #111827; font-family: Arial, sans-serif; margin: 0; }
        main { margin: 52px auto; max-width: 620px; padding: 0 18px; }
        .card { background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 30px; }
        .status { border-radius: 999px; display: inline-flex; font-weight: 700; margin-bottom: 18px; padding: 7px 13px; }
        .valid { background: #dcfce7; color: #166534; }
        .invalid { background: #fee2e2; color: #991b1b; }
        h1 { font-size: 26px; margin: 0 0 22px; }
        .row { border-top: 1px solid #e5e7eb; display: flex; gap: 16px; justify-content: space-between; padding: 13px 0; }
        .row span { color: #6b7280; }
    </style>
</head>
<body>
    <main>
        <div class="card">
            <div class="status {{ $isValid ? 'valid' : 'invalid' }}">{{ $isValid ? 'Credencial valida' : 'Credencial invalida' }}</div>
            <h1>{{ $credential->member->full_name }}</h1>
            <div class="row"><span>Codigo</span><strong>{{ $credential->code }}</strong></div>
            <div class="row"><span>Titulo</span><strong>{{ $credential->title }}</strong></div>
            <div class="row"><span>Emissao</span><strong>{{ $credential->issued_on?->format('d/m/Y') }}</strong></div>
            <div class="row"><span>Validade</span><strong>{{ $credential->expires_on?->format('d/m/Y') ?: 'Sem vencimento' }}</strong></div>
        </div>
    </main>
</body>
</html>
