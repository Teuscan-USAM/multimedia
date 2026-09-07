<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reportes extends Model
{
    protected $table = 'reportes';

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
