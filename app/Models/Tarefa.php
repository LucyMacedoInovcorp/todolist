<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    protected $fillable = [
        'titulo',
        'descricao',
        'concluida',
        'data_vencimento',
        'prioridade'
    ];

    protected $casts = [
        'concluida' => 'boolean',
        'data_vencimento' => 'date',
    ];
}
