<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Certificado {{ $certificate->certificate_number }}</title>
    <style>
        @page { size: A4 landscape; margin: 12mm; }
        body { margin: 0; font-family: Georgia, serif; background: #f6f0df; color: #252019; }
        .certificate { min-height: 185mm; border: 10px double #b8952e; padding: 28px; display: grid; place-items: center; text-align: center; background: #fffaf0; }
        h1 { font-size: 58px; margin: 0; letter-spacing: 2px; color: #7c5f1b; }
        h2 { font-size: 32px; margin: 18px 0; }
        p { font-size: 20px; line-height: 1.6; max-width: 820px; }
        .name { font-size: 42px; font-weight: 700; border-bottom: 2px solid #b8952e; padding: 6px 32px; display: inline-block; }
        .footer { width: 100%; display: flex; justify-content: space-between; align-items: end; margin-top: 36px; font-family: Arial, sans-serif; }
        .qr img { width: 120px; height: 120px; }
        .signature { border-top: 1px solid #252019; padding-top: 8px; min-width: 260px; }
        .print { position: fixed; top: 12px; right: 12px; }
        @media print { .print { display: none; } body { background: #fff; } }
    </style>
</head>
<body>
<button class="print" onclick="window.print()">Imprimir / salvar PDF</button>
<main class="certificate">
    <div>
        <h1>Certificado</h1>
        <h2>Escola Dominical</h2>
        <p>Certificamos que</p>
        <div class="name">{{ $certificate->enrollment->member->full_name }}</div>
        <p>concluiu o curso <strong>{{ $certificate->enrollment->class->course_name ?: $certificate->enrollment->class->name }}</strong>, no periodo <strong>{{ $certificate->enrollment->class->period_label ?: 'registrado' }}</strong>, com frequencia de <strong>{{ $certificate->enrollment->attendance_percent ?? 0 }}%</strong> e media final <strong>{{ $certificate->enrollment->final_grade ?? 'N/A' }}</strong>.</p>
        <p>Emitido em {{ $certificate->issued_on?->format('d/m/Y') }}. Certificado nº {{ $certificate->certificate_number }}.</p>
        <div class="footer">
            <div class="signature">{{ $certificate->signer_name ?: config('app.name') }}<br><small>{{ $certificate->signer_title ?: 'Direcao da Escola Dominical' }}</small></div>
            <div class="qr">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data={{ urlencode($validationUrl) }}" alt="QR Code de validacao">
                <br><small>Validar certificado</small>
            </div>
        </div>
    </div>
</main>
</body>
</html>
