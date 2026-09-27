<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnderecoController;

Route::get('/enderecos', [EnderecoController::class, 'index']);

Route::get('/enderecos/{cep}', [EnderecoController::class, 'consultar']);
