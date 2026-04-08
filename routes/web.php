<?php

use App\Http\Controllers\CadastroController;
use App\Http\Controllers\CarteirinhaController;
use Illuminate\Support\Facades\Route;

// Agrupando as rotas com limite de 25 requisições por minuto
Route::middleware('throttle:25,1')->group(function () {
    
    Route::redirect('/', '/carteirinhas');

    Route::get('/carteirinhas', [CarteirinhaController::class, 'create'])->name('carteirinhas.create');
    Route::post('/carteirinhas', [CarteirinhaController::class, 'search'])->name('carteirinhas.search');
    Route::get('/carteirinhas/{id}/pdf', [CarteirinhaController::class, 'pdf'])->name('carteirinhas.pdf');

    Route::get('/cadastro', [CadastroController::class, 'create'])->name('cadastro.create');
    Route::post('/cadastro', [CadastroController::class, 'store'])->name('cadastro.store');
    
});


Route::any('storage/{path}', function () {
    abort(404);
})->where('path', '.*');

Route::any('_boost/browser-logs', fn() => abort(404));
