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

    public function pdf(Request $request, int $id): StreamedResponse
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

private function generatePdfResponse(Carteirinha $carteirinha): StreamedResponse
{
    // 1. Carrega a imagem de fundo (mantendo sua lógica original)
    $backgroundImagePath = public_path('imgs/carteira2025.png');
    
    if (!file_exists($backgroundImagePath)) {
        abort(500, 'Imagem de fundo não encontrada.');
    }
    
    $backgroundImageContents = file_get_contents($backgroundImagePath);
    $base64Image = base64_encode($backgroundImageContents);

    // 2. Renderiza o HTML da View
    $html = view('carteirinhas.pdf', [
        'backgroundImage' => $base64Image,
        'carteirinha' => $carteirinha,
    ])->render();

    // 3. Configura o Dompdf
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true); // Útil se houver imagens externas

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);

    // (Opcional) Define o tamanho do papel. Ex: A4, portrait ou landscape
    $dompdf->setPaper('A4', 'portrait');

    // 4. Renderiza o PDF em memória
    $dompdf->render();
    $pdfOutput = $dompdf->output();

    $fileName = 'carteirinha-'.$carteirinha->id.'.pdf';

    // 5. Retorna o stream para download/exibição
    return response()->streamDownload(function () use ($pdfOutput): void {
        echo $pdfOutput;
    }, $fileName, [
        'Content-Type' => 'application/pdf',
        // 'inline' exibe no navegador, 'attachment' força o download
        'Content-Disposition' => 'inline; filename="'.$fileName.'"',
    ]);
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
