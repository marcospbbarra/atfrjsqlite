<?php

namespace App\Http\Controllers;

use App\Models\Carteirinha;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class CarteirinhaController extends Controller
{
    public function create(): View
    {
        return view('carteirinhas.create');
    }

    public function search(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email:rfc', 'max:255'],
        ]);

        $carteirinha = Carteirinha::query()
            ->select(['id', 'nome', 'email'])
            ->where('email', $validated['email'])
            ->first();

        if ($carteirinha === null) {
            return to_route('carteirinhas.create')
                ->withInput()
                ->with('lookup_not_found', true);
        }

        return to_route('carteirinhas.create')
            ->with('carteirinha_link', route('carteirinhas.pdf', [
                'id' => $carteirinha->id,
                'email' => $carteirinha->email,
            ]))
            ->with('carteirinha', $carteirinha->only(['id', 'nome', 'email']));
    }

    /**
     * Gera o PDF da carteirinha após validar o e-mail.
     */
    public function pdf(Request $request, int $id): Response
    {
        $validated = $request->validate([
            'email' => ['required', 'email:rfc', 'max:255'],
        ]);

        $carteirinha = Carteirinha::query()
            ->select(['id', 'nome', 'email', 'categoria', 'afiliacao'])
            ->whereKey($id)
            ->where('email', $validated['email'])
            ->firstOrFail();

        return $this->generatePdfResponse($carteirinha);
    }

    /**
     * Lógica interna para renderizar o PDF via DomPDF (Pure PHP).
     */
    private function generatePdfResponse(Carteirinha $carteirinha): Response
    {
        // 1. Validar imagem de fundo
        $backgroundImagePath = public_path('imgs/carteira2025.png');
        
        if (!file_exists($backgroundImagePath)) {
            abort(500, 'Imagem de fundo não encontrada.');
        }
        
        // Converter imagem para Base64 (evita problemas de permissão de path no DomPDF)
        $imageData = base64_encode(file_get_contents($backgroundImagePath));
        $base64Image = 'data:image/png;base64,' . $imageData;

        // 2. Preparar os dados para a view
        $data = [
            'backgroundImage' => $base64Image,
            'carteirinha' => $carteirinha,
        ];

        // 3. Configurar e Gerar o PDF
        // O Facade do DomPDF processa tudo em memória, sem proc_open
        $pdf = Pdf::loadView('carteirinhas.pdf', $data);

        $pdf->setPaper('A4', 'portrait')
            ->setWarnings(false)
            ->setOption([
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
            ]);

        $fileName = 'carteirinha-'.$carteirinha->id.'.pdf';

        // 4. Retorna a Response correta para o navegador
        // O método stream() já configura os headers de PDF automaticamente
        return $pdf->stream($fileName);
    }

    public function sync(Request $request)
        {
            // 1. Valida se o que chegou é um array de registros
            $data = $request->validate([
                '*.id'        => 'required|integer',
                '*.nome'      => 'required|string',
                '*.categoria' => 'required|string',
                '*.afiliacao' => 'required|integer',
                '*.email'     => 'required|email',
            ]);

            try {
                // 2. Inicia uma transação para segurança dos dados
                DB::beginTransaction();

                // 3. Deleta todos os registros atuais
                Carteirinha::query()->delete();

                // 4. Insere os novos registros em massa (mais rápido)
                Carteirinha::insert($data);

                DB::commit();

                return response()->json([
                    'message' => 'Carteirinhas sincronizadas com sucesso!',
                    'count'   => count($data)
                ], 200);

            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Erro ao sincronizar dados',
                    'error'   => $e->getMessage()
                ], 500);
            }
    }    
}
