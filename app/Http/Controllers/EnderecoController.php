<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Endereco;

class EnderecoController extends Controller
{

    public function consultar(string $cep)
    {

        $cep = preg_replace('/\D/', '', $cep);

        if (strlen($cep) !== 8) {
            return response()->json([
                'mensagem' => 'CEP inválido.'
            ], 400);
        }

        $endereco = Endereco::where('cep', $cep)->first();

        if ($endereco) {
            $endereco->increment('consultas');

            return response()->json($endereco);
        }

        $resposta = Http::get("https://viacep.com.br/ws/{$cep}/json/");

        $dados = $resposta->json();

        if (isset($dados['erro']) && $dados['erro']) {
            return response()->json([
                'mensagem' => 'CEP não encontrado.'
            ], 404);
        }

        $endereco = Endereco::updateOrCreate(
            ['cep' => $cep],
            [
                'logradouro' => $dados['logradouro'],
                'bairro' => $dados['bairro'],
                'localidade' => $dados['localidade'],
                'uf' => $dados['uf'],
            ]
        );

        return response()->json($endereco);
    }

    public function buscar(Request $request)
    {
        $cep = $request->cep;

        $resposta = $this->consultar($cep);

        if ($resposta->getStatusCode() !== 200) {
            return $resposta;
        }

        return redirect('/enderecos');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Endereco::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
