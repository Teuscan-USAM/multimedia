<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaFinanza extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'iglesia_id',
        'nombre',
        'tipo', // ingreso|egreso
    ];

    public function iglesia()
    {
        return $this->belongsTo(Iglesia::class, 'iglesia_id');
    }
}

