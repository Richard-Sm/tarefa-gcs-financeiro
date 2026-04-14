<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Verifique esta linha
use Illuminate\Database\Eloquent\Model;

class Lancamento extends Model
{
    use HasFactory; // Verifique esta linha aqui dentro!

    protected static function newFactory()
    {
    return \Database\Factories\LancamentoFactory::new();
    }

    protected $fillable = [
        'descricao', 'data_lancamento', 'valor', 'tipo_lancamento', 'situacao'
    ];
}
