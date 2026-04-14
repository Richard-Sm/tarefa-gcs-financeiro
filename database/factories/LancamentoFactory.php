<?php

namespace Database\Factories;

use App\Models\Lancamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class LancamentoFactory extends Factory
{
    protected $model = Lancamento::class;

    public function definition(): array
    {
        return [
            'descricao' => fake()->sentence(3),
            'data_lancamento' => fake()->date(),
            'valor' => fake()->randomFloat(2, 10, 1000),
            'tipo_lancamento' => fake()->randomElement(['Receita', 'Despesa']),
            'situacao' => fake()->randomElement(['Confirmado', 'Pendente', 'Pago']),
        ];
    }
}
