<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AtfrjUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'atfrj@atfrj.org.br'],
            [
                'name' => 'atfrj',
                'password' => 'pCLr8XVIG$!u',
            ],
        );
    }
}
