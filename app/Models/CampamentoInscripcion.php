<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampamentoInscripcion extends Model
{
    use HasFactory;

    protected $table = 'campamento_inscripciones';

    protected $fillable = [
        'nombre_completo',
        'fecha_nacimiento',
        'edad',
        'sexo',
        'telefono',
        'distrito_id',
        'pertenece_iglesia',
        'iglesia',
        'departamento_catalogo_id',
        'primera_vez',
        'encargado_nombre',
        'encargado_telefono',
        'tiene_alergias',
        'alergias',
    ];

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
            'distrito_id' => 'integer',
            'primera_vez' => 'boolean',
            'tiene_alergias' => 'boolean',
            'pertenece_iglesia' => 'boolean',
        ];
    }

    public function departamentoCatalogo()
    {
        return $this->belongsTo(DepartamentoCatalogo::class, 'departamento_catalogo_id');
    }

    public function distrito()
    {
        return $this->belongsTo(CtlDistrito::class, 'distrito_id', 'id_distrito');
    }
}
