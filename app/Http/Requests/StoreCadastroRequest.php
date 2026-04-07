<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCadastroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'autorizacao_lgpd' => $this->boolean('autorizacao_lgpd'),
            'autorizacao_mailing' => $this->boolean('autorizacao_mailing'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc', 'max:255'],
            'ano_filiacao' => ['required', 'integer', 'digits:4'],
            'local_de_atendimento' => ['required', 'string', 'max:255'],
            'telefone' => ['required', 'string', 'max:50'],
            'formacao' => ['required', 'string', 'max:255'],
            'autorizacao_lgpd' => ['required', 'boolean'],
            'autorizacao_mailing' => ['required', 'boolean'],
            'status' => ['required', 'string', 'max:15'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'ano_filiacao' => 'ano de filiacao',
            'local_de_atendimento' => 'local de atendimento',
            'autorizacao_lgpd' => 'autorizacao LGPD',
            'autorizacao_mailing' => 'autorizacao de mailing',
        ];
    }
}
