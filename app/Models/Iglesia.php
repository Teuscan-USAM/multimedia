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
}

