<?php

namespace App\Models;

use Database\Factories\CadastroFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'nome',
    'email',
    'ano_filiacao',
    'local_de_atendimento',
    'telefone',
    'formacao',
    'autorizacao_lgpd',
    'autorizacao_mailing',
    'status',
])]
class Cadastro extends Model
{
    /** @use HasFactory<CadastroFactory> */
    use HasFactory;

    protected $table = 'cadastro';

    protected $attributes = [
        'status' => 'adicionado',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'nome' => 'encrypted',
            'email' => 'encrypted',
            'ano_filiacao' => 'integer',
            'telefone' => 'encrypted',
            'autorizacao_lgpd' => 'boolean',
            'autorizacao_mailing' => 'boolean',
        ];
    }
}
