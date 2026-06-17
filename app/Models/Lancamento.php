<?php

namespace App\Models;

use Database\Factories\LancamentoFactory; // Verifique esta linha
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lancamento extends Model
{
    use HasFactory; // Verifique esta linha aqui dentro!

    protected static function newFactory()
    {
        return LancamentoFactory::new();
    }

    protected $fillable = [
        'descricao', 'data_lancamento', 'valor', 'tipo_lancamento', 'situacao', 'user_id', 'observacoes',
    ];
}
