<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CtlDistrito extends Model
{
    protected $table = 'ctl_distrito';
    protected $primaryKey = 'id_distrito';
    public $timestamps = false;

    public function municipio(): BelongsTo
    {
        return $this->belongsTo(CtlMunicipio::class, 'id_municipio', 'id_municipio');
    }
}
