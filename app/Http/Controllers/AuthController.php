<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Lógica de autenticação aqui
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $atemptLogin = auth()->attempt(['email' => $email, 'password' => $password]);
        if (! $atemptLogin) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        $user = auth()->user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token, 'message' => 'Login bem-sucedido'], 200);

    }
}
