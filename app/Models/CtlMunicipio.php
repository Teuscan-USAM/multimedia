<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CtlMunicipio extends Model
{
    protected $table = 'ctl_municipio';
    protected $primaryKey = 'id_municipio';
    public $timestamps = false;

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(CtlDepartamento::class, 'id_departamento', 'id_departamento');
    }

    public function distritos(): HasMany
    {
        return $this->hasMany(CtlDistrito::class, 'id_municipio', 'id_municipio');
    }
}
