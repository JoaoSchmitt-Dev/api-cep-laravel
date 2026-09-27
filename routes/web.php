<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnderecoController;
use App\Models\Endereco;

Route::get('/enderecos', function () {

    $enderecos = Endereco::all();

    return view('enderecos.index', compact('enderecos'));
});

Route::get('/consultar-cep', [EnderecoController::class, 'buscar']);
