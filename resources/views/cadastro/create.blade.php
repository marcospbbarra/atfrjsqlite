@extends('layouts.form')

@section('title', 'Cadastro')

@section('aside')
    <h1 class="display-6 fw-semibold mb-3">Formulario de cadastro</h1>
    <p class="mb-0 fs-5" style="color: rgba(240,247,245,0.7)">
        Preencha seus dados.
    </p>
@endsection

@section('aside-tiles')
    <div class="col-12">
        <div class="feature-tile p-3 h-100">
            <div class="small text-uppercase aside-accent mb-2" style="letter-spacing:.15em">Atualize seus dados</div>
            <div class="fw-semibold">Mantenha seus dados visíveis no site</div>
        </div>
    </div>
@endsection

@section('content')
    <div class="d-flex flex-column flex-sm-row align-items-sm-start justify-content-between gap-3 mb-4">
        <div>
            <h2 class="h3 mb-0">Informacoes do formulario</h2>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success border-0 rounded-4 py-4 px-4" role="alert">
            <h5 class="alert-heading fw-semibold mb-1">Cadastro realizado!</h5>
            <p class="mb-0">{{ session('status') }}</p>
        </div>
    @else

        @if ($errors->any())
            <div class="alert alert-danger border-0 rounded-4" role="alert">
                Existem campos com erro no formulario.
            </div>
        @endif

        <form action="{{ route('cadastro.store') }}" method="POST" class="row g-4">
            @csrf

            <div class="col-12">
                <label for="nome" class="form-label fw-semibold">Nome</label>
                <input id="nome" name="nome" type="text" value="{{ old('nome') }}" class="form-control form-control-lg @error('nome') is-invalid @enderror" required>
                @error('nome')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label fw-semibold">E-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control form-control-lg @error('email') is-invalid @enderror" required>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="telefone" class="form-label fw-semibold">Telefone</label>
                <input id="telefone" name="telefone" type="text" value="{{ old('telefone') }}" class="form-control form-control-lg @error('telefone') is-invalid @enderror" required>
                @error('telefone')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="ano_filiacao" class="form-label fw-semibold">Ano de filiacao</label>
                <input id="ano_filiacao" name="ano_filiacao" type="number" min="1000" max="9999" value="{{ old('ano_filiacao') }}" class="form-control form-control-lg @error('ano_filiacao') is-invalid @enderror" required>
                @error('ano_filiacao')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="local_de_atendimento" class="form-label fw-semibold">Local de atendimento</label>
                <input id="local_de_atendimento" name="local_de_atendimento" type="text" value="{{ old('local_de_atendimento') }}" class="form-control form-control-lg @error('local_de_atendimento') is-invalid @enderror" required>
                @error('local_de_atendimento')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="formacao" class="form-label fw-semibold">Formacao</label>
                <input id="formacao" name="formacao" type="text" value="{{ old('formacao') }}" class="form-control form-control-lg @error('formacao') is-invalid @enderror" required>
                @error('formacao')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="status" class="form-label fw-semibold">Status</label>
                <input id="status" name="status" type="text" maxlength="15" value="{{ old('status') }}" class="form-control form-control-lg @error('status') is-invalid @enderror" required>
                @error('status')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <div class="checkbox-card p-4 h-100">
                    <div class="form-check">
                        <input id="autorizacao_lgpd" name="autorizacao_lgpd" type="checkbox" value="1" @checked(old('autorizacao_lgpd')) class="form-check-input @error('autorizacao_lgpd') is-invalid @enderror">
                        <label class="form-check-label" for="autorizacao_lgpd">
                            <span class="d-block fw-semibold">Autorizacao LGPD</span>
                            <span class="text-secondary">Autorizo a ATFRJ a inserir e manter meus dados pessoais e profissionais em seu banco de dados, publicando no site apenas os itens selecionados acima, por tempo indeterminado ou até que eu peça exclusão dos mesmos formalmente.</span>
                        </label>
                    </div>
                    @error('autorizacao_lgpd')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <div class="checkbox-card p-4 h-100">
                    <div class="form-check">
                        <input id="autorizacao_mailing" name="autorizacao_mailing" type="checkbox" value="1" @checked(old('autorizacao_mailing')) class="form-check-input @error('autorizacao_mailing') is-invalid @enderror">
                        <label class="form-check-label" for="autorizacao_mailing">
                            <span class="d-block fw-semibold">Autorizacao de marketing</span>
                            <span class="text-secondary">Autorizo o envio de mensagens, newsletter, notícias ou divulgação de eventos em meu e-mail, whatsapp ou outros grupos a serem criados, por tempo indeterminado ou até que eu peça exclusão formalmente.</span>
                        </label>
                    </div>
                    @error('autorizacao_mailing')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 pt-2 border-top">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 pt-3">
                    <p class="text-secondary mb-0"></p>
                    <button type="submit" class="btn btn-brand btn-lg px-4">Salvar cadastro</button>
                </div>
            </div>
        </form>

    @endif
@endsection
