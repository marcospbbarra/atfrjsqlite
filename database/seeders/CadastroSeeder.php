<?php

namespace Database\Seeders;

use App\Models\Cadastro;
use Illuminate\Database\Seeder;

class CadastroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cadastro::factory()->count(10)->create();
    }
}
