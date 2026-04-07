<?php

use App\Http\Controllers\CadastroController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/cadastro');

Route::get('/cadastro', [CadastroController::class, 'create'])->name('cadastro.create');
Route::post('/cadastro', [CadastroController::class, 'store'])->name('cadastro.store');
