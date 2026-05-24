@extends('saas-site.layout')

@section('title', 'Fale conosco - SaaS Igreja')

@section('content')
<section class="support-wrap">
    <div class="container">
        <div class="support-card">
            <h1>Fale conosco</h1>
            <p style="color:var(--muted);line-height:1.7">Envie sua dúvida, solicite uma demonstração ou peça ajuda para escolher o melhor plano.</p>

            @if (session('status'))
                <p style="background:#dcfce7;border:1px solid #86efac;padding:14px;border-radius:8px">{{ session('status') }}</p>
            @endif

            @if ($errors->any())
                <div style="background:#fff1f2;border:1px solid #fecdd3;padding:14px;border-radius:8px;color:#9f1239;margin-bottom:18px">
                    Revise os campos destacados e tente novamente.
                </div>
            @endif

            <form method="post" action="{{ route('saas.support.store') }}">
                @csrf
                <div class="form-grid">
                    <label for="email">E-mail *</label>
                    <input id="email" name="email" type="email" placeholder="voce@igreja.com" value="{{ old('email') }}" required>

                    <label for="name">Nome</label>
                    <input id="name" name="name" placeholder="Seu nome" value="{{ old('name') }}">

                    <label for="subject">Assunto *</label>
                    <input id="subject" name="subject" value="{{ old('subject', request('plano') ? 'Tenho interesse no plano '.request('plano') : '') }}" required>

                    <label for="message">Mensagem *</label>
                    <textarea id="message" name="message" required>{{ old('message') }}</textarea>
                </div>
                <div style="border-top:1px solid #e5e7eb;margin-top:28px;padding-top:18px">
                    <button class="btn btn-blue" type="submit">Enviar mensagem</button>
                    <a class="btn btn-outline" href="{{ route('saas.home') }}">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
