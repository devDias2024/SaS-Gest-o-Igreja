<!doctype html>
<html lang="pt-BR">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Validacao de certificado</title><style>body{font-family:Inter,Arial,sans-serif;background:#f6f4ef;color:#24212a;margin:0}.card{width:min(720px,calc(100% - 32px));margin:48px auto;background:#fff;border:1px solid #e6e1d8;border-radius:8px;padding:28px;box-shadow:0 16px 34px rgba(36,33,42,.06)}h1{color:#006b57}</style></head>
<body><main class="card"><h1>Certificado valido</h1><p><strong>Numero:</strong> {{ $certificate->certificate_number }}</p><p><strong>Aluno:</strong> {{ $certificate->enrollment->member->full_name }}</p><p><strong>Curso:</strong> {{ $certificate->enrollment->class->course_name ?: $certificate->enrollment->class->name }}</p><p><strong>Emitido em:</strong> {{ $certificate->issued_on?->format('d/m/Y') }}</p><p><strong>Status:</strong> {{ $certificate->status }}</p></main></body>
</html>
