<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iglesia extends Model
{
    use HasFactory;

    protected $table = 'iglesias';

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'ciudad',
        'responsable',
        'direccion_google_maps',
    ];

    public function pastores()
    {
        return $this->belongsToMany(User::class, 'iglesia_pastor', 'iglesia_id', 'pastor_id')
            ->withTimestamps();
    }

    public function departamentos()
    {
        return $this->hasMany(Departamento::class, 'iglesia_id');
    }

    public function departamentosHabilitados()
    {
        return $this->hasMany(Departamento::class, 'iglesia_id')->habilitados();
    }

    public function catalogoDepartamentos()
    {
        return $this->belongsToMany(DepartamentoCatalogo::class, 'departments', 'iglesia_id', 'catalogo_id')
            ->withPivot(['habilitado', 'pastor_id', 'miembro_id'])
            ->withTimestamps();
    }
}

