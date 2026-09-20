<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anuncio extends Model
{
     protected $table = 'anuncios';

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'seccion',
        'estado'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
