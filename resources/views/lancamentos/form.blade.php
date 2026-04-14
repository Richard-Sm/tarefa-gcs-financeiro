<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($lancamento) ? 'Editar' : 'Novo' }} Lançamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">{{ isset($lancamento) ? 'Editar' : 'Novo' }} Lançamento</h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($lancamento) ? route('lancamentos.update', $lancamento->id) : route('lancamentos.store') }}" method="POST">
                        @csrf
                        @if(isset($lancamento))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-bold">Descrição</label>
                            <input type="text" name="descricao" class="form-control" value="{{ old('descricao', $lancamento->descricao ?? '') }}" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label fw-bold">Data</label>
                                <input type="date" name="data_lancamento" class="form-control" value="{{ old('data_lancamento', $lancamento->data_lancamento ?? date('Y-m-d')) }}" required>
                            </div>
                            <div class="col">
                                <label class="form-label fw-bold">Valor (R$)</label>
                                <input type="number" step="0.01" name="valor" class="form-control" value="{{ old('valor', $lancamento->valor ?? '') }}" required>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col">
                                <label class="form-label fw-bold">Tipo</label>
                                <select name="tipo_lancamento" class="form-select">
                                    <option value="Receita" {{ old('tipo_lancamento', $lancamento->tipo_lancamento ?? '') == 'Receita' ? 'selected' : '' }}>Receita</option>
                                    <option value="Despesa" {{ old('tipo_lancamento', $lancamento->tipo_lancamento ?? '') == 'Despesa' ? 'selected' : '' }}>Despesa</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label fw-bold">Situação</label>
                                <select name="situacao" class="form-select">
                                    <option value="Confirmado" {{ old('situacao', $lancamento->situacao ?? '') == 'Confirmado' ? 'selected' : '' }}>Confirmado</option>
                                    <option value="Pendente" {{ old('situacao', $lancamento->situacao ?? '') == 'Pendente' ? 'selected' : '' }}>Pendente</option>
                                    <option value="Pago" {{ old('situacao', $lancamento->situacao ?? '') == 'Pago' ? 'selected' : '' }}>Pago</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('lancamentos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
