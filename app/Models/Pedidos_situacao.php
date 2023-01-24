<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedidos_situacao extends Model
{
    use HasFactory;
    protected $table = 'pedido_situacao';
    protected $fiable = [
        "id" ,
        "descricao" ,
         ];

    
}
