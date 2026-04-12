<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIpAddress
{
    // Lista de IPs permitidos
    protected $allowedIps = [
        '127.0.0.1',    // Localhost IPv4
        '::1',          // Localhost IPv6
        '192.168.1.50', // Exemplo de IP da sua rede
        '192.99.46.28', // IP do servidor de produção
        // Adicione outros IPs aqui
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (!in_array($request->ip(), $this->allowedIps)) {
            return response()->json([
                'message' => 'Acesso negado. Seu IP (' . $request->ip() . ') não está autorizado.'
            ], 403);
        }

        return $next($request);
    }
}