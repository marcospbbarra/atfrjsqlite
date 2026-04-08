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
        $backgroundImagePath = public_path('imgs/carteira2025.png');
        $backgroundImageContents = file_get_contents($backgroundImagePath);

        if ($backgroundImageContents === false) {
            abort(500, 'Nao foi possivel carregar a imagem da carteirinha.');
        }

        $html = view('carteirinhas.pdf', [
            'backgroundImage' => base64_encode($backgroundImageContents),
            'carteirinha' => $carteirinha,
        ])->render();

        $temporaryDirectory = storage_path('app/temp');

        if (! is_dir($temporaryDirectory)) {
            mkdir($temporaryDirectory, 0755, true);
        }

        $htmlPath = $temporaryDirectory.'/'.Str::uuid().'.html';
        $pdfPath = $temporaryDirectory.'/'.Str::uuid().'.pdf';

        file_put_contents($htmlPath, $html);

        $process = new Process([
            '/usr/bin/google-chrome',
            '--headless',
            '--disable-gpu',
            '--no-sandbox',
            '--disable-dev-shm-usage',
            '--allow-file-access-from-files',
            '--no-pdf-header-footer',
            '--print-to-pdf='.$pdfPath,
            'file://'.$htmlPath,
        ]);

        $process->setTimeout(60);
        $process->run();

        @unlink($htmlPath);

        if (! $process->isSuccessful() || ! file_exists($pdfPath)) {
            @unlink($pdfPath);

            abort(500, 'Nao foi possivel gerar o PDF da carteirinha.');
        }

        $fileName = 'carteirinha-'.$carteirinha->id.'.pdf';

        return response()->streamDownload(function () use ($pdfPath): void {
            $stream = fopen($pdfPath, 'rb');

            if ($stream === false) {
                return;
            }

            fpassthru($stream);
            fclose($stream);
            @unlink($pdfPath);
        }, $fileName, [
            'Content-Type' => 'application/pdf',
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
