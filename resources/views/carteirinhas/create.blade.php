@extends('layouts.form')

@section('title', 'Carteirinhas')

@section('aside')
    <h1 class="display-6 fw-semibold mb-3">Carteirinhas</h1>
    <p class="mb-0 fs-5" style="color: rgba(240,247,245,0.7)">
        Digite seu e-mail para localizar a carteirinha.
    </p>
@endsection

@section('aside-tiles')
    <div class="col-12">
        <div class="feature-tile p-3 h-100">
            <div class="small text-uppercase aside-accent mb-2" style="letter-spacing:.15em">Busca de cadastro</div>
            <div class="fw-semibold">Ao localizar o cadastro, exibimos um link para abrir a carteirinha em PDF.</div>
        </div>
    </div>
@endsection

@section('content')
    <div class="d-flex flex-column flex-sm-row align-items-sm-start justify-content-between gap-3 mb-4">
        <div>
            <h2 class="h3 mb-0">Consulta de carteirinha</h2>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger border-0 rounded-4" role="alert">
            Informe um e-mail valido para consultar.
        </div>
    @endif

    @if (session('carteirinha_link'))
        <div class="alert alert-success border-0 rounded-4 py-4 px-4" role="alert" aria-live="polite">
            <h5 class="alert-heading fw-semibold mb-1">Cadastro encontrado</h5>
            <p class="mb-2">
                Acesse sua carteirinha <a href="{{ session('carteirinha_link') }}" class="alert-link" target="_blank" rel="noopener">neste link</a>.
            </p>
            <p class="mb-1"><strong>Nome:</strong> {{ data_get(session('carteirinha'), 'nome') }}</p>
        </div>
    @elseif (session('lookup_not_found'))
        <div class="alert alert-warning border-0 rounded-4 py-4 px-4" role="alert" aria-live="polite">
            <h5 class="alert-heading fw-semibold mb-1">Cadastro nao encontrado</h5>
            <p class="mb-0">O e-mail informado nao existe na base de dados.</p>
        </div>
    @endif

    @unless (session('carteirinha_link'))
        <form action="{{ route('carteirinhas.search') }}" method="POST" class="row g-4" novalidate>
            @csrf

            <div class="col-12">
                <label for="email" class="form-label fw-semibold">E-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control form-control-lg @error('email') is-invalid @enderror" required>
                <div class="form-text mt-2">Use o mesmo e-mail registrado na base.</div>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-brand btn-lg px-4">Localizar carteirinha</button>
            </div>
        </form>
    @endunless
@endsection
