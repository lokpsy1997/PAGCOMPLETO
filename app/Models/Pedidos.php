<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    use HasFactory;
    protected $table = 'pedidos';
    public $timestamps = false;
    protected $fiable = [
        "id" ,
        "nome" ,
        "cpf_cnpj" ,
        "email" ,
        "tipo_pessoa" ,
        "data_nasc" ,
        "id_loja",
        "id_situacao",
    ];

    
}
