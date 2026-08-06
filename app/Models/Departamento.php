<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $fillable = [
        'iglesia_id',
        'pastor_id',
        'miembro_id',
        'nombre',
        'descripcion',
    ];

    public function iglesia()
    {
        return $this->belongsTo(Iglesia::class, 'iglesia_id');
    }

    public function pastor()
    {
        return $this->belongsTo(User::class, 'pastor_id');
    }

    public function miembro()
    {
        return $this->belongsTo(User::class, 'miembro_id');
    }

    public function ingresos()
    {
        return $this->hasMany(Ingreso::class, 'departamento_id');
    }

    public function egresos()
    {
        return $this->hasMany(Egreso::class, 'departamento_id');
    }
}

