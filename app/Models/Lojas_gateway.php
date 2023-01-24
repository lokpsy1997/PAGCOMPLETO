<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lojas_gateway extends Model
{
    use HasFactory;
    protected $table = 'lojas_gateway';
    protected $fiable = [
        "id",
        "id_loja" ,
        "id_gateway"
    ];

    
}
