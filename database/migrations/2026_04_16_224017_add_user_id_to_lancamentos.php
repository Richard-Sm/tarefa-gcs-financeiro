<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
    Schema::table('lancamentos', function (Blueprint $table) {
        // Criamos o campo que liga ao usuário. 
        // Colocamos 'nullable' para não dar erro com os dados que você já cadastrou.
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
    });
    }	
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lancamentos', function (Blueprint $table) {
            //
        });
    }
};
