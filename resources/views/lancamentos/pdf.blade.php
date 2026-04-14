<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Lançamentos</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .receita { color: green; font-weight: bold; }
        .despesa { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Relatório de Despesas e Receitas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Data</th>
                <th>Valor (R$)</th>
                <th>Tipo</th>
                <th>Situação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lancamentos as $lancamento)
                <tr>
                    <td>{{ $lancamento->id }}</td>
                    <td>{{ $lancamento->descricao }}</td>
                    <td>{{ \Carbon\Carbon::parse($lancamento->data_lancamento)->format('d/m/Y') }}</td>
                    <td>{{ number_format($lancamento->valor, 2, ',', '.') }}</td>
                    <td class="{{ $lancamento->tipo_lancamento == 'Receita' ? 'receita' : 'despesa' }}">
                        {{ $lancamento->tipo_lancamento }}
                    </td>
                    <td>{{ $lancamento->situacao }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
