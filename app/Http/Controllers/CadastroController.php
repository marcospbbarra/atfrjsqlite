<?php

namespace App\Http\Controllers;

use App\Models\Cadastro;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CadastroController extends Controller
{
    public function create(): View
    {
        return view('cadastro.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            rules: [
                'nome' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email:rfc', 'max:255'],
                'ano_filiacao' => ['required', 'integer', 'digits:4'],
                'local_de_atendimento' => ['required', 'string', 'max:255'],
                'telefone' => ['required', 'string', 'max:50'],
                'formacao' => ['required', 'string', 'max:255'],
                'autorizacao_lgpd' => ['required', 'boolean'],
                'autorizacao_mailing' => ['nullable', 'boolean'],
            ],
            attributes: [
                'ano_filiacao' => 'ano de filiação',
                'local_de_atendimento' => 'local de atendimento',
                'autorizacao_lgpd' => 'autorização LGPD',
                'autorizacao_mailing' => 'autorização de mailing',
            ],
        );

        $validated['autorizacao_lgpd'] = $request->boolean('autorizacao_lgpd');
        $validated['autorizacao_mailing'] = $request->boolean('autorizacao_mailing');
        $validated['status'] = 'adicionado';

        Cadastro::create($validated);

        return to_route('cadastro.create')->with('status', 'Cadastro salvo com sucesso.');
    }
}
