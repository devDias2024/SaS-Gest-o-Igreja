<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $form->title }}</title>
    <style>
        :root { color-scheme: light; --brand: #006b57; --ink: #24212a; --muted: #6f6875; --line: #e8e5df; --paper: #fbfaf7; }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; background: var(--paper); color: var(--ink); }
        main { width: min(760px, calc(100% - 32px)); margin: 48px auto; }
        header { margin-bottom: 28px; }
        h1 { margin: 0 0 10px; font-size: clamp(2rem, 5vw, 3.5rem); line-height: .95; letter-spacing: 0; }
        p { color: var(--muted); line-height: 1.6; }
        form { background: #fff; border: 1px solid var(--line); border-radius: 8px; padding: clamp(18px, 4vw, 34px); box-shadow: 0 18px 45px rgba(36, 33, 42, .08); }
        .field { margin-bottom: 18px; }
        label, legend { display: block; font-weight: 800; margin-bottom: 8px; }
        input, textarea, select { width: 100%; border: 1px solid var(--line); border-radius: 8px; min-height: 46px; padding: 11px 13px; font: inherit; background: #fff; }
        textarea { min-height: 120px; resize: vertical; }
        fieldset { border: 0; padding: 0; margin: 0 0 18px; }
        .choice { display: flex; align-items: center; gap: 8px; margin: 8px 0; color: var(--ink); }
        .choice input { width: 18px; min-height: 18px; }
        .help, .error { display: block; margin-top: 6px; font-size: .9rem; color: var(--muted); }
        .error { color: #b42318; }
        .status { margin-bottom: 18px; border-radius: 8px; padding: 13px 15px; background: #e9f8f1; color: #006b57; font-weight: 800; }
        .actions { display: flex; justify-content: flex-end; margin-top: 24px; }
        .actions { gap: 10px; flex-wrap: wrap; }
        button { border: 0; border-radius: 8px; background: var(--brand); color: #fff; min-height: 48px; padding: 0 22px; font-weight: 900; cursor: pointer; }
        button.secondary { background: #ebe7df; color: var(--ink); }
        button:disabled { opacity: .55; cursor: not-allowed; }
        canvas { width: 100%; height: 160px; border: 1px solid var(--line); border-radius: 8px; background: #fff; touch-action: none; }
        [data-honeypot] { position: absolute; left: -9999px; opacity: 0; }
        dialog { width: min(620px, calc(100% - 28px)); border: 0; border-radius: 8px; padding: 0; box-shadow: 0 24px 70px rgba(36, 33, 42, .24); }
        dialog::backdrop { background: rgba(36, 33, 42, .5); }
        .modal { padding: 24px; }
        .preview-row { padding: 10px 0; border-bottom: 1px solid var(--line); }
        .preview-row:last-child { border-bottom: 0; }
    </style>
</head>
<body>
<main>
    <header>
        <h1>{{ $form->title }}</h1>
        @if($form->description)
            <p>{{ $form->description }}</p>
        @endif
    </header>

    @if(session('status'))
        <div class="status">{{ session('status') }}</div>
    @endif

    @if($preview ?? false)
        <div class="status">Modo previa: este formulario nao envia respostas.</div>
    @endif

    <form id="processForm" method="post" action="{{ route('process-forms.store', $form->slug) }}" enctype="multipart/form-data" data-draft-key="process-form-draft-{{ $form->id }}">
        @csrf

        @if($form->captcha_enabled)
            <div data-honeypot>
                <label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
            </div>
        @endif

        @foreach($fields as $field)
            @php($data = $field['data'])
            @php($key = $data['key'])
            <div class="field" data-field="{{ $key }}" data-condition-field="{{ $data['conditional_field'] ?? '' }}" data-condition-value="{{ $data['conditional_value'] ?? '' }}">
                @if(in_array($field['type'], ['single_choice', 'multi_choice'], true))
                    <fieldset>
                        <legend>{{ $data['label'] }} @if($data['required'] ?? false)*@endif</legend>
                        @if($field['type'] === 'single_choice' && ($data['display'] ?? 'dropdown') === 'dropdown')
                            <select name="{{ $key }}">
                                <option value="">Selecione</option>
                                @foreach(($data['options'] ?? []) as $option)
                                    <option value="{{ $option }}" @selected(old($key) === $option)>{{ $option }}</option>
                                @endforeach
                            </select>
                        @else
                            @foreach(($data['options'] ?? []) as $option)
                                <label class="choice">
                                    <input type="{{ $field['type'] === 'single_choice' ? 'radio' : 'checkbox' }}" name="{{ $field['type'] === 'single_choice' ? $key : $key . '[]' }}" value="{{ $option }}" @checked($field['type'] === 'single_choice' ? old($key) === $option : in_array($option, old($key, []), true))>
                                    <span>{{ $option }}</span>
                                </label>
                            @endforeach
                        @endif
                    </fieldset>
                @elseif($field['type'] === 'agreement')
                    <label class="choice">
                        <input type="checkbox" name="{{ $key }}" value="1" @checked(old($key))>
                        <span>{{ $data['agreement_text'] ?? $data['label'] }} @if($data['required'] ?? false)*@endif</span>
                    </label>
                @elseif($field['type'] === 'signature')
                    <label>{{ $data['label'] }} @if($data['required'] ?? false)*@endif</label>
                    <canvas data-signature-canvas="{{ $key }}"></canvas>
                    <input type="hidden" name="{{ $key }}" value="{{ old($key) }}">
                @else
                    <label for="{{ $key }}">{{ $data['label'] }} @if($data['required'] ?? false)*@endif</label>
                    @switch($field['type'])
                        @case('long_text')
                            <textarea id="{{ $key }}" name="{{ $key }}" placeholder="{{ $data['placeholder'] ?? '' }}">{{ old($key) }}</textarea>
                            @break
                        @case('date_time')
                            <input id="{{ $key }}" type="datetime-local" name="{{ $key }}" value="{{ old($key) }}">
                            @break
                        @case('file_upload')
                            <input id="{{ $key }}" type="file" name="{{ $key }}">
                            @break
                        @default
                            <input id="{{ $key }}" type="{{ $field['type'] === 'email' ? 'email' : ($field['type'] === 'number' ? 'number' : 'text') }}" name="{{ $key }}" value="{{ old($key) }}" placeholder="{{ $data['placeholder'] ?? '' }}">
                    @endswitch
                @endif

                @if($data['help_text'] ?? null)
                    <small class="help">{{ $data['help_text'] }}</small>
                @endif
                @error($key)
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>
        @endforeach

        <div class="actions">
            <button class="secondary" type="button" id="previewButton">Pre-visualizar</button>
            @if($form->allow_drafts)
                <button class="secondary" type="button" id="clearDraftButton">Limpar rascunho</button>
            @endif
            <button type="submit" @disabled($preview ?? false)>Enviar resposta</button>
        </div>
    </form>
</main>

<dialog id="previewDialog">
    <div class="modal">
        <h2>Pre-visualizacao</h2>
        <p>Confira suas respostas antes de enviar.</p>
        <div id="previewContent"></div>
        <div class="actions">
            <button class="secondary" type="button" id="closePreviewButton">Editar</button>
            <button type="button" id="confirmSubmitButton" @disabled($preview ?? false)>Confirmar envio</button>
        </div>
    </div>
</dialog>

<script>
    const form = document.getElementById('processForm');
    const allowDrafts = @json((bool) $form->allow_drafts);
    const isPreview = @json((bool) ($preview ?? false));
    const draftKey = form.dataset.draftKey;

    document.querySelectorAll('[data-condition-field]').forEach((field) => {
        const source = field.dataset.conditionField;
        const expected = field.dataset.conditionValue;
        if (!source) return;

        const update = () => {
            const checked = document.querySelector(`[name="${source}"]:checked`);
            const input = checked || document.querySelector(`[name="${source}"]`);
            field.style.display = input && input.value === expected ? '' : 'none';
        };

        document.querySelectorAll(`[name="${source}"], [name="${source}[]"]`).forEach((input) => input.addEventListener('change', update));
        update();
    });

    document.querySelectorAll('[data-signature-canvas]').forEach((canvas) => {
        const input = document.querySelector(`input[name="${canvas.dataset.signatureCanvas}"]`);
        const ctx = canvas.getContext('2d');
        let drawing = false;

        const resize = () => {
            canvas.width = canvas.offsetWidth * devicePixelRatio;
            canvas.height = canvas.offsetHeight * devicePixelRatio;
            ctx.scale(devicePixelRatio, devicePixelRatio);
            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.strokeStyle = '#24212a';
        };
        const point = (event) => {
            const rect = canvas.getBoundingClientRect();
            const touch = event.touches ? event.touches[0] : event;
            return { x: touch.clientX - rect.left, y: touch.clientY - rect.top };
        };
        const start = (event) => { drawing = true; const p = point(event); ctx.beginPath(); ctx.moveTo(p.x, p.y); };
        const move = (event) => { if (!drawing) return; event.preventDefault(); const p = point(event); ctx.lineTo(p.x, p.y); ctx.stroke(); input.value = canvas.toDataURL('image/png'); };
        const end = () => { drawing = false; input.value = canvas.toDataURL('image/png'); };

        resize();
        addEventListener('resize', resize);
        canvas.addEventListener('mousedown', start);
        canvas.addEventListener('mousemove', move);
        canvas.addEventListener('mouseup', end);
        canvas.addEventListener('mouseleave', end);
        canvas.addEventListener('touchstart', start, { passive: true });
        canvas.addEventListener('touchmove', move, { passive: false });
        canvas.addEventListener('touchend', end);
    });

    const serializableInputs = () => [...form.querySelectorAll('input, textarea, select')]
        .filter((input) => input.name && input.type !== 'file' && input.name !== '_token' && input.name !== 'website');

    if (allowDrafts && !isPreview) {
        try {
            const draft = JSON.parse(localStorage.getItem(draftKey) || '{}');
            serializableInputs().forEach((input) => {
                if (!(input.name in draft)) return;

                if (input.type === 'checkbox' || input.type === 'radio') {
                    input.checked = Array.isArray(draft[input.name])
                        ? draft[input.name].includes(input.value)
                        : draft[input.name] === input.value || draft[input.name] === true;
                } else {
                    input.value = draft[input.name] ?? '';
                }
            });
        } catch (error) {}

        form.addEventListener('input', () => {
            const draft = {};
            serializableInputs().forEach((input) => {
                if (input.type === 'checkbox') {
                    draft[input.name] ??= [];
                    if (input.checked) draft[input.name].push(input.value);
                    return;
                }

                if (input.type === 'radio') {
                    if (input.checked) draft[input.name] = input.value;
                    return;
                }

                draft[input.name] = input.value;
            });
            localStorage.setItem(draftKey, JSON.stringify(draft));
        });

        document.getElementById('clearDraftButton')?.addEventListener('click', () => {
            localStorage.removeItem(draftKey);
            location.reload();
        });

        form.addEventListener('submit', () => localStorage.removeItem(draftKey));
    }

    const previewDialog = document.getElementById('previewDialog');
    const previewContent = document.getElementById('previewContent');
    const buildPreview = () => {
        const rows = [];
        document.querySelectorAll('.field').forEach((field) => {
            if (field.style.display === 'none') return;

            const label = field.querySelector('label, legend')?.textContent?.replace('*', '').trim();
            const named = [...field.querySelectorAll('input, textarea, select')].filter((input) => input.name && input.name !== 'website');
            const values = named.filter((input) => {
                if (['checkbox', 'radio'].includes(input.type)) return input.checked;
                if (input.type === 'hidden' && input.previousElementSibling?.tagName === 'CANVAS') return Boolean(input.value);
                return input.value;
            }).map((input) => input.type === 'file' ? (input.files[0]?.name || '') : (input.type === 'hidden' ? 'Assinatura preenchida' : input.value));

            if (label) rows.push(`<div class="preview-row"><strong>${label}</strong><br><span>${values.join(', ') || 'Nao preenchido'}</span></div>`);
        });
        previewContent.innerHTML = rows.join('');
    };

    document.getElementById('previewButton').addEventListener('click', () => {
        buildPreview();
        previewDialog.showModal();
    });
    document.getElementById('closePreviewButton').addEventListener('click', () => previewDialog.close());
    document.getElementById('confirmSubmitButton').addEventListener('click', () => {
        previewDialog.close();
        form.requestSubmit();
    });
</script>
</body>
</html>
