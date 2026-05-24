<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Credencial {{ $credential->code }}</title>
    <style>
        @page { size: A4 portrait; margin: 8mm; }
        :root {
            --base: {{ $template?->background_color ?: '#d97706' }};
            --text: {{ $template?->text_color ?: '#ffffff' }};
            --radius: {{ ($template?->border_shape ?? 'rounded') === 'square' ? '0' : '3mm' }};
            --photo-radius: {{ ($template?->photo_shape ?? 'round') === 'round' ? '999px' : (($template?->photo_shape ?? 'round') === 'square' ? '0' : '10px') }};
        }
        * { box-sizing: border-box; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        body { margin: 0; color: #111827; font-family: Arial, sans-serif; background: #f3f4f6; }
        .toolbar { align-items: center; display: flex; gap: 12px; justify-content: center; padding: 18px; }
        .toolbar button { background: #d97706; border: 0; border-radius: 6px; color: #111827; cursor: pointer; font-weight: 700; padding: 11px 18px; }
        .page { display: grid; gap: 18px; justify-content: center; margin: 0 auto; padding: 10px 0 34px; width: 86mm; }
        .label { color: #6b7280; font-size: 11px; font-weight: 700; margin-bottom: 6px; text-align: center; text-transform: uppercase; }
        .credential {
            border-radius: var(--radius);
            color: var(--text);
            height: 54mm;
            overflow: hidden;
            padding: 4mm;
            position: relative;
            width: 86mm;
        }
        .artwork {
            height: 100%;
            inset: 0;
            object-fit: cover;
            position: absolute;
            width: 100%;
            z-index: 0;
        }
        .credential-content { position: relative; z-index: 1; }
        .front .credential-content {
            display: grid;
            gap: 2.5mm 3mm;
            grid-template-columns: 19mm minmax(0, 1fr) 16mm;
            grid-template-rows: auto minmax(0, 1fr);
            height: 100%;
        }
        .photo { align-self: end; background: rgba(255,255,255,.22); border: 1px solid rgba(255,255,255,.78); border-radius: var(--photo-radius); height: 25mm; overflow: hidden; width: 19mm; }
        .photo img { height: 100%; object-fit: cover; width: 100%; }
        h1 { font-size: 12px; line-height: 1.13; margin: 0 0 3px; }
        .brand { align-items: center; display: flex; gap: 2mm; grid-column: 1 / -1; margin: 0; }
        .brand-logo {
            align-items: center;
            background: rgba(255,255,255,.94);
            border: 1px solid rgba(255,255,255,.56);
            border-radius: 999px;
            box-shadow: 0 3px 10px rgba(0,0,0,.14);
            color: var(--base);
            display: flex;
            flex: 0 0 9mm;
            font-size: 10px;
            font-weight: 800;
            height: 9mm;
            justify-content: center;
            overflow: hidden;
            width: 9mm;
        }
        .brand-logo img { height: 100%; object-fit: contain; padding: 1mm; width: 100%; }
        .church { font-size: 9px; font-weight: 700; line-height: 1.2; opacity: .96; }
        .church small { display: block; font-size: 7px; font-weight: 600; opacity: .78; text-transform: uppercase; }
        .member-data { align-self: end; min-width: 0; }
        .info { display: grid; gap: 2px; font-size: 7.5px; line-height: 1.15; }
        .info b { font-size: 6.5px; opacity: .74; display: block; text-transform: uppercase; }
        .qr { align-self: end; background: #fff; border-radius: 1.5mm; padding: 1mm; text-align: center; }
        .qr img { display: block; height: 14mm; width: 14mm; }
        .back .credential-content { display: grid; gap: 4mm; grid-template-columns: 1fr 29mm; height: 100%; }
        .back-copy { font-size: 8px; line-height: 1.45; margin: 3mm 0 0; }
        .meta { display: grid; gap: 1.5mm; font-size: 7.5px; margin-top: 3mm; }
        .sign { border-top: 1px solid currentColor; margin-top: 8mm; padding-top: 1mm; font-size: 7px; text-align: center; }
        .measure { color: #6b7280; font-size: 12px; margin: 2px 0 0; text-align: center; }
        @media print {
            body { background: #fff; }
            .toolbar { display: none; }
            .page { gap: 8mm; padding: 0; width: 86mm; }
            .credential { height: 54mm; width: 86mm; }
            .measure { display: none; }
        }
    </style>
</head>
<body>
    <div class="toolbar"><button type="button" onclick="window.print()">Imprimir / salvar PDF</button></div>
    @php
        $photo = collect($credential->member->photos ?? [])->first();
        $churchName = $template?->church_name ?: ($siteIdentity['church_name'] ?? null) ?: config('app.name');
        $churchLogoPath = $template?->church_logo ?: ($siteIdentity['logo_image'] ?? null);
        $churchLogo = $churchLogoPath ? \Illuminate\Support\Facades\Storage::disk('public')->url($churchLogoPath) : null;
        $generatedLogoMark = collect(preg_split('/\s+/', $churchName))
            ->filter()
            ->take(2)
            ->map(fn (string $word): string => mb_strtoupper(mb_substr($word, 0, 1)))
            ->implode('');
        $churchLogoMark = $template?->church_name
            ? $generatedLogoMark
            : ($siteIdentity['logo_mark_text'] ?? $generatedLogoMark);
        $frontBackground = $template?->front_background ? \Illuminate\Support\Facades\Storage::disk('public')->url($template->front_background) : null;
        $backBackground = $template?->back_background ? \Illuminate\Support\Facades\Storage::disk('public')->url($template->back_background) : null;
        $documentType = $template?->document_type ?? 'member';
        $displayDocument = $documentType !== 'none'
            && ($documentType === 'member' || $credential->member->document_type === $documentType)
            ? $credential->member->document_number
            : null;
        $displayDocumentLabel = $documentType === 'member'
            ? strtoupper($credential->member->document_type ?: 'Documento')
            : strtoupper($documentType);
        $fallbackArtwork = 'data:image/svg+xml;base64,'.base64_encode(
            '<svg xmlns="http://www.w3.org/2000/svg" width="860" height="540" viewBox="0 0 860 540">'
            .'<rect width="860" height="540" fill="'.e($template?->background_color ?: '#d97706').'"/>'
            .'<path d="M0 95C192 0 338 228 546 105C678 27 765 75 860 12V540H0Z" fill="#ffffff" fill-opacity=".14"/>'
            .'<path d="M0 395C240 252 396 520 602 358C714 270 790 316 860 258V540H0Z" fill="#111827" fill-opacity=".14"/>'
            .'</svg>'
        );
    @endphp
    <main class="page">
        <section>
            <div class="label">Frente</div>
            <div class="credential front">
                <img class="artwork" src="{{ $frontBackground ?: $fallbackArtwork }}" alt="">
                <div class="credential-content">
                    <div class="brand">
                        <div class="brand-logo">
                            @if ($churchLogo)
                                <img src="{{ $churchLogo }}" alt="Logo {{ $churchName }}">
                            @else
                                {{ $churchLogoMark ?: 'IG' }}
                            @endif
                        </div>
                        <div class="church">
                            {{ $churchName }}
                            <small>Credencial de membro</small>
                        </div>
                    </div>
                    <div class="photo">
                        @if ($photo)
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($photo) }}" alt="{{ $credential->member->full_name }}">
                        @endif
                    </div>
                    <div class="member-data">
                        <h1>{{ $credential->member->full_name }}</h1>
                        <div class="info">
                            <span><b>Titulo</b>{{ $credential->title }}</span>
                            <span><b>Categoria</b>{{ $credential->member->category?->name ?: 'Membro' }}</span>
                            @if ($displayDocument)<span><b>{{ $displayDocumentLabel }}</b>{{ $displayDocument }}</span>@endif
                            <span><b>Codigo</b>{{ $credential->code }}</span>
                        </div>
                    </div>
                    <div class="qr">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($validationUrl) }}" alt="QR Code">
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="label">Verso</div>
            <div class="credential back">
                <img class="artwork" src="{{ $backBackground ?: $fallbackArtwork }}" alt="">
                <div class="credential-content">
                    <div>
                        <p class="back-copy">{{ $template?->back_description ?: 'Esta credencial identifica seu portador como membro da comunidade local.' }}</p>
                        <div class="meta">
                            <span><strong>Emissao:</strong> {{ $credential->issued_on?->format('d/m/Y') }}</span>
                            <span><strong>Validade:</strong> {{ $credential->expires_on?->format('d/m/Y') ?: 'Sem vencimento' }}</span>
                            @if ($credential->blood_type)<span><strong>Tipo sanguineo:</strong> {{ $credential->blood_type }}</span>@endif
                        </div>
                    </div>
                    <div>
                        @if ($template?->show_holder_signature)
                            <div class="sign">Assinatura do portador</div>
                        @endif
                        @if ($template?->show_authority_signature)
                            <div class="sign">{{ $template?->authority_name ?: 'Autoridade responsavel' }}<br>{{ $template?->authority_title }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <p class="measure">Medida padrao: 86 mm x 54 mm (8,6 cm x 5,4 cm)</p>
    </main>
</body>
</html>
