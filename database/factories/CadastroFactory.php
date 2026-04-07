<?php

namespace Database\Factories;

use App\Models\Cadastro;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cadastro>
 */
class CadastroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'ano_filiacao' => (int) fake()->year(),
            'local_de_atendimento' => fake()->city(),
            'telefone' => fake()->phoneNumber(),
            'formacao' => fake()->randomElement([
                'Graduacao',
                'Especializacao',
                'Mestrado',
                'Doutorado',
            ]),
            'autorizacao_lgpd' => fake()->boolean(90),
            'autorizacao_mailing' => fake()->boolean(60),
            'status' => fake()->randomElement(['ativo', 'inativo', 'pendente']),
        ];
    }
}
