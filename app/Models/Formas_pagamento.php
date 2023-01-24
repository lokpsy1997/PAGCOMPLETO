<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formas_pagamento extends Model
{
    use HasFactory;
    protected $table = 'formas_pagamento';
    protected $fiable = [
        "id" ,
        "descricao" , 
    ];

    
}
