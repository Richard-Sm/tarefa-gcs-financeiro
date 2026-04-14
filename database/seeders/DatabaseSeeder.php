<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lancamento;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Lancamento::insert([
            ['descricao' => 'Salário Mensal', 'data_lancamento' => '2026-03-01', 'valor' => 5000.00, 'tipo_lancamento' => 'Receita', 'situacao' => 'Confirmado'],
            ['descricao' => 'Aluguel', 'data_lancamento' => '2026-03-05', 'valor' => 1200.00, 'tipo_lancamento' => 'Despesa', 'situacao' => 'Pago'],
            ['descricao' => 'Supermercado', 'data_lancamento' => '2026-03-07', 'valor' => 450.00, 'tipo_lancamento' => 'Despesa', 'situacao' => 'Pago'],
            ['descricao' => 'Venda de Monitor', 'data_lancamento' => '2026-03-10', 'valor' => 800.00, 'tipo_lancamento' => 'Receita', 'situacao' => 'Confirmado'],
            ['descricao' => 'Conta de Luz', 'data_lancamento' => '2026-03-12', 'valor' => 150.00, 'tipo_lancamento' => 'Despesa', 'situacao' => 'Pendente'],
            ['descricao' => 'Internet', 'data_lancamento' => '2026-03-15', 'valor' => 100.00, 'tipo_lancamento' => 'Despesa', 'situacao' => 'Pago'],
            ['descricao' => 'Freelance Design', 'data_lancamento' => '2026-03-18', 'valor' => 1200.00, 'tipo_lancamento' => 'Receita', 'situacao' => 'Confirmado'],
            ['descricao' => 'Gasolina', 'data_lancamento' => '2026-03-20', 'valor' => 250.00, 'tipo_lancamento' => 'Despesa', 'situacao' => 'Pago'],
            ['descricao' => 'Jantar Restaurante', 'data_lancamento' => '2026-03-22', 'valor' => 120.00, 'tipo_lancamento' => 'Despesa', 'situacao' => 'Pago'],
            ['descricao' => 'Academia', 'data_lancamento' => '2026-03-25', 'valor' => 90.00, 'tipo_lancamento' => 'Despesa', 'situacao' => 'Pago'],
        ]);
    }
}
