<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QR Code - {{ $event->title }}</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f8fafc; color: #111827; }
        main { min-height: 100vh; display: grid; place-items: center; padding: 32px; box-sizing: border-box; }
        .panel { width: min(560px, 100%); text-align: center; border: 1px solid #e5e7eb; border-radius: 16px; padding: 32px; background: #fff; }
        img { width: min(320px, 80vw); height: auto; image-rendering: pixelated; }
        .muted { color: #6b7280; }
        .url { word-break: break-all; font-size: 14px; margin-top: 18px; }
        @media print { body { background: #fff; } .panel { border: 0; } }
    </style>
</head>
<body>
    <main>
        <div class="panel">
            <p class="muted">{{ $event->starts_at->format('d/m/Y H:i') }}</p>
            <h1>{{ $event->title }}</h1>
            <img
                alt="QR Code para check-in"
                src="https://api.qrserver.com/v1/create-qr-code/?size=320x320&data={{ urlencode($checkInUrl) }}"
            >
            <p class="url">{{ $checkInUrl }}</p>
        </div>
    </main>
</body>
</html>
