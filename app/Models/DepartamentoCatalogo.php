<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartamentoCatalogo extends Model
{
    use HasFactory;

    protected $table = 'departamento_catalogo';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function departamentos()
    {
        return $this->hasMany(Departamento::class, 'catalogo_id');
    }

    public function iglesiasHabilitadas()
    {
        return $this->belongsToMany(Iglesia::class, 'departments', 'catalogo_id', 'iglesia_id')
            ->wherePivot('habilitado', true)
            ->withTimestamps();
    }
}
