<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LancamentoController;

Route::get('/', function () {
    return view('welcome');
});

// Rota do PDF deve vir ANTES do resource
Route::get('lancamentos/export/pdf', [LancamentoController::class, 'exportPdf'])->name('lancamentos.pdf');

// Cria automaticamente todas as rotas de CRUD (index, create, store, edit, update, destroy)
Route::resource('lancamentos', LancamentoController::class);
