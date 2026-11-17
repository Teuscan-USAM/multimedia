<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CtlDepartamento extends Model
{
    protected $table = 'ctl_departamento';
    protected $primaryKey = 'id_departamento';
    public $timestamps = false;

    public function municipios(): HasMany
    {
        return $this->hasMany(CtlMunicipio::class, 'id_departamento', 'id_departamento');
    }
}
