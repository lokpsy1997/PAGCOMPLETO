<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedidos_pagamentos extends Model
{
    use HasFactory;
    protected $table = 'pedidos_pagamentos';
    public $timestamps = false;
    protected $fiable = [
        "id" ,
        "id_pedido",
        "id_formapagto" ,
        "qtd_parcelas" ,
        "retorno_intermediador" ,
        "data_processamento" ,
        "num_cartao" ,
        "nome_portador" ,
        "codigo_verificacao",
        "vencimento"
    ];

    
}
