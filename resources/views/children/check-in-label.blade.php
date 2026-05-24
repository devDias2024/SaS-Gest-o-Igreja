<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Etiqueta {{ $checkIn->check_in_code }}</title>
    <style>
        @page{size:80mm auto;margin:4mm}body{margin:0;font-family:Arial,sans-serif;color:#111}.label{width:72mm;padding:4mm;border:1px dashed #999}.center{text-align:center}.code{font-size:26px;font-weight:800;letter-spacing:2px}.name{font-size:18px;font-weight:800;margin-top:8px}.meta{font-size:12px;margin-top:4px}.pickup{margin-top:12px;padding-top:10px;border-top:1px solid #111}.small{font-size:10px}@media print{button{display:none}.label{border:0}}
    </style>
</head>
<body>
    <button onclick="window.print()">Imprimir</button>
    <div class="label">
        <div class="center">
            <div class="small">CHECK-IN INFANTIL</div>
            <div class="code">{{ $checkIn->pickup_code }}</div>
            <div class="small">Codigo de retirada</div>
        </div>
        <div class="name">{{ $checkIn->child->full_name }}</div>
        <div class="meta">Sala: {{ $checkIn->ageGroup?->name ?? 'A definir' }}</div>
        <div class="meta">Entrada: {{ $checkIn->checked_in_at?->format('d/m/Y H:i') }}</div>
        <div class="meta">Responsavel: {{ $checkIn->checkedInBy?->name ?? 'Nao informado' }}</div>
        @if ($checkIn->child->allergies)
            <div class="meta"><strong>Alergias:</strong> {{ $checkIn->child->allergies }}</div>
        @endif
        @if ($checkIn->child->medical_conditions)
            <div class="meta"><strong>Condicoes:</strong> {{ $checkIn->child->medical_conditions }}</div>
        @endif
        <div class="pickup">
            <div class="small">Etiqueta crianca/responsavel</div>
            <div class="small">Validar codigo antes da retirada: {{ $checkIn->check_in_code }}</div>
        </div>
    </div>
</body>
</html>
