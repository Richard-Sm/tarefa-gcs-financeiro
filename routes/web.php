<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LancamentoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    // Redireciona direto para a sua lista de finanças
    return redirect('/lancamentos');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Rotas do Perfil (que o Breeze precisa para o menu)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Nossas rotas de Lançamentos protegidas
    Route::get('lancamentos/export/pdf', [LancamentoController::class, 'exportPdf'])->name('lancamentos.pdf');
    Route::resource('lancamentos', LancamentoController::class);
});

require __DIR__.'/auth.php';
