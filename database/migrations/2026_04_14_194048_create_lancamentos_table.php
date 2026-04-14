<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    	Schema::create('lancamentos', function (Blueprint $table) {
        	$table->id(); // Equivalente ao SERIAL PRIMARY KEY
        	$table->string('descricao', 200);
        	$table->date('data_lancamento');
        	$table->decimal('valor', 10, 2);
        	$table->string('tipo_lancamento', 20); // Ex: 'Receita' ou 'Despesa'
        	$table->string('situacao', 20); // Ex: 'Confirmado', 'Pendente', 'Pago'
        	$table->timestamps(); // Cria magicamente colunas de 'data de criação' e 'data de atualização'
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lancamentos');
    }
};
