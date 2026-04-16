<?php

namespace App\Http\Controllers;

use App\Models\Lancamento;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificacaoLancamento;

class LancamentoController extends Controller
{
    // 1. LISTAR E FILTRAR (Cumprindo o requisito de Filtros)
    public function index(Request $request)
    {
        $query = auth()->user()->lancamentos();

        // Filtro por Data Inicial e Final
        if ($request->filled('data_inicio')) {
            $query->whereDate('data_lancamento', '>=', $request->data_inicio);
        }
        if ($request->filled('data_fim')) {
            $query->whereDate('data_lancamento', '<=', $request->data_fim);
        }

        // Filtro por Situação (Status)
        if ($request->filled('situacao')) {
            $query->where('situacao', $request->situacao);
        }

        // Busca os dados filtrados ordenando pelos mais recentes
        $lancamentos = $query->orderBy('id', 'desc')->get();
        return view('lancamentos.index', compact('lancamentos'));
    }

    // 2. TELA DE CRIAÇÃO
    public function create()
    {
        return view('lancamentos.form');
    }

// 3. SALVAR NOVO LANÇAMENTO NO BANCO
    public function store(Request $request)
{
    // 1. Validação dos campos
    $validated = $request->validate([
        'descricao' => 'required|string|max:200',
        'data_lancamento' => 'required|date',
        'valor' => 'required|numeric',
        'tipo_lancamento' => 'required|string',
        'situacao' => 'required|string',
    ]);

    // 2. Injetamos o ID do usuário logado no array de dados validados
    $validated['user_id'] = auth()->id();

    // 3. Criamos o lançamento vinculado ao usuário
    $lancamento = Lancamento::create($validated);

    // 4. Dispara o e-mail para o e-mail do próprio usuário logado
    Mail::to(auth()->user()->email)->send(new NotificacaoLancamento($lancamento, 'Criado'));

    // 5. Redireciona com mensagem de sucesso
    return redirect()->route('lancamentos.index')->with('success', 'Lançamento criado com sucesso!');
}
    // 4. TELA DE EDIÇÃO
    public function edit(Lancamento $lancamento)
    {
        return view('lancamentos.form', compact('lancamento'));
    }

    // 5. ATUALIZAR DADOS NO BANCO
    public function update(Request $request, Lancamento $lancamento)
    {
        $validated = $request->validate([
            'descricao' => 'required|string|max:200',
            'data_lancamento' => 'required|date',
            'valor' => 'required|numeric',
            'tipo_lancamento' => 'required|string',
            'situacao' => 'required|string',
        ]);

        $lancamento->update($validated);

        // Dispara o e-mail
        Mail::to(auth()->user()->email)->send(new NotificacaoLancamento($lancamento, 'Atualizado'));
        return redirect()->route('lancamentos.index')->with('success', 'Lançamento atualizado com sucesso!');
    }

    // 6. EXCLUIR DO BANCO
    public function destroy(Lancamento $lancamento)
    {
        $lancamento->delete();
        return redirect()->route('lancamentos.index')->with('success', 'Lançamento excluído com sucesso!');
    }
    
    // 7. EXPORTAR PARA PDF
    public function exportPdf(Request $request)
    {
        $query = Lancamento::query();

        if ($request->filled('data_inicio')) {
            $query->whereDate('data_lancamento', '>=', $request->data_inicio);
        }
        if ($request->filled('data_fim')) {
            $query->whereDate('data_lancamento', '<=', $request->data_fim);
        }
        if ($request->filled('situacao')) {
            $query->where('situacao', $request->situacao);
        }

        $lancamentos = $query->orderBy('data_lancamento', 'desc')->get();

        $pdf = Pdf::loadView('lancamentos.pdf', compact('lancamentos'));
        
        return $pdf->download('relatorio_lancamentos.pdf');
    }	
}
