<?php

use App\Http\Controllers\CadastroController;
use App\Http\Controllers\CarteirinhaController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/carteirinhas');

Route::get('/carteirinhas', [CarteirinhaController::class, 'create'])->name('carteirinhas.create');
Route::post('/carteirinhas', [CarteirinhaController::class, 'search'])->name('carteirinhas.search');
Route::get('/carteirinhas/{id}/pdf', [CarteirinhaController::class, 'pdf'])->name('carteirinhas.pdf');

Route::get('/cadastro', [CadastroController::class, 'create'])->name('cadastro.create');
Route::post('/cadastro', [CadastroController::class, 'store'])->name('cadastro.store');
