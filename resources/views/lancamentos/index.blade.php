<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão Financeira</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0"><i class="bi bi-funnel"></i> Filtros</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('lancamentos.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Data Início</label>
                    <input type="date" name="data_inicio" class="form-control" value="{{ request('data_inicio') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Data Fim</label>
                    <input type="date" name="data_fim" class="form-control" value="{{ request('data_fim') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Situação</label>
                    <select name="situacao" class="form-select">
                        <option value="">Todas</option>
                        <option value="Confirmado" {{ request('situacao') == 'Confirmado' ? 'selected' : '' }}>Confirmado</option>
                        <option value="Pendente" {{ request('situacao') == 'Pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="Pago" {{ request('situacao') == 'Pago' ? 'selected' : '' }}>Pago</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Filtrar</button>
                    <a href="{{ route('lancamentos.index') }}" class="btn btn-light">Limpar</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="bi bi-wallet2"></i> Lançamentos</h4>
            <div>
		<a href="{{ route('lancamentos.pdf', request()->all()) }}" class="btn btn-danger btn-sm me-2" target="_blank"><i class="bi bi-file-earmark-pdf"></i> Exportar PDF</a>
		<a href="{{ route('lancamentos.create') }}" class="btn btn-success btn-sm"><i class="bi bi-plus-lg"></i> Novo Lançamento</a>
	    </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Descrição</th>
                            <th>Data</th>
                            <th>Valor (R$)</th>
                            <th>Tipo</th>
                            <th>Situação</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lancamentos as $lancamento)
                            <tr>
                                <td>{{ $lancamento->id }}</td>
                                <td><strong>{{ $lancamento->descricao }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($lancamento->data_lancamento)->format('d/m/Y') }}</td>
                                <td>{{ number_format($lancamento->valor, 2, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $lancamento->tipo_lancamento == 'Receita' ? 'success' : 'danger' }}">
                                        {{ $lancamento->tipo_lancamento }}
                                    </span>
                                </td>
                                <td>{{ $lancamento->situacao }}</td>
                                <td class="text-center">
                                    <a href="{{ route('lancamentos.edit', $lancamento->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i></a>
                                    
                                    <form action="{{ route('lancamentos.destroy', $lancamento->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Nenhum lançamento encontrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>
