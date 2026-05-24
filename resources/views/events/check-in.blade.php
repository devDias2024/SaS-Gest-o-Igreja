<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Check-in - {{ $event->title }}</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #101113; color: #f8fafc; }
        main { width: min(720px, calc(100% - 32px)); margin: 48px auto; }
        .panel { background: #18191c; border: 1px solid #2b2d31; border-radius: 12px; padding: 28px; }
        label { display: block; margin: 18px 0 8px; font-weight: 700; }
        input, select { width: 100%; box-sizing: border-box; border-radius: 8px; border: 1px solid #3a3d43; padding: 12px; background: #232427; color: #fff; }
        button { margin-top: 22px; border: 0; border-radius: 8px; padding: 12px 18px; background: #f59e0b; color: #111827; font-weight: 700; cursor: pointer; }
        .muted { color: #a1a1aa; }
        .success { background: #14532d; border: 1px solid #22c55e; padding: 12px; border-radius: 8px; }
    </style>
</head>
<body>
    <main>
        <div class="panel">
            <p class="muted">{{ $event->starts_at->format('d/m/Y H:i') }}</p>
            <h1>{{ $event->title }}</h1>
            @if (session('status'))
                <p class="success">{{ session('status') }}</p>
            @endif
            <form method="post" action="{{ route('events.check-in.store', $token) }}">
                @csrf
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

                <label for="member_id">Membro</label>
                <select name="member_id" id="member_id">
                    <option value="">Sou visitante/convidado</option>
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}">{{ $member->full_name }}</option>
                    @endforeach
                </select>

                <label for="guest_name">Nome do visitante</label>
                <input name="guest_name" id="guest_name" maxlength="255">

                <button type="submit">Confirmar presenca</button>
            </form>
        </div>
    </main>
    <script>
        navigator.geolocation?.getCurrentPosition((position) => {
            document.getElementById('latitude').value = position.coords.latitude;
            document.getElementById('longitude').value = position.coords.longitude;
        });
    </script>
</body>
</html>
