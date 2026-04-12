<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarteirinhaController;
use App\Http\Controllers\CadastroController;


Route::get('/status', function () {
    return response()->json(['status' => 'ok']);
})->name('api.status');

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('api.login');

Route::middleware(['auth:sanctum', 'check.ip'])->group(function () {
    Route::post('/carteirinhas/sync', [CarteirinhaController::class, 'sync'])->middleware('throttle:5,60');
    
    // Nova rota para listar os cadastros
    Route::get('/cadastros', [CadastroController::class, 'index']);
});