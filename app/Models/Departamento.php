<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $with = ['catalogo'];

    protected $fillable = [
        'iglesia_id',
        'catalogo_id',
        'pastor_id',
        'miembro_id',
        'habilitado',
    ];

    protected $casts = [
        'habilitado' => 'boolean',
    ];

    public function iglesia()
    {
        return $this->belongsTo(Iglesia::class, 'iglesia_id');
    }

    public function catalogo()
    {
        return $this->belongsTo(DepartamentoCatalogo::class, 'catalogo_id');
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

    public function getNombreAttribute(): ?string
    {
        return $this->catalogo?->nombre;
    }

    public function getDescripcionAttribute(): ?string
    {
        return $this->catalogo?->descripcion;
    }

    public function scopeHabilitados(Builder $query): Builder
    {
        return $query->where('habilitado', true);
    }

    public static function syncHabilitadosParaIglesia(Iglesia $iglesia, array $catalogoIds): void
    {
        $catalogoIds = collect($catalogoIds)
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        $existentes = static::where('iglesia_id', $iglesia->id)->get()->keyBy('catalogo_id');

        foreach (DepartamentoCatalogo::query()->orderBy('id')->get() as $catalogo) {
            $row = $existentes->get($catalogo->id);
            $habilitar = $catalogoIds->contains($catalogo->id);

            if ($habilitar) {
                if ($row) {
                    if (! $row->habilitado) {
                        $row->update(['habilitado' => true]);
                    }
                } else {
                    static::create([
                        'iglesia_id' => $iglesia->id,
                        'catalogo_id' => $catalogo->id,
                        'habilitado' => true,
                    ]);
                }
            } elseif ($row && $row->habilitado) {
                $row->update(['habilitado' => false]);
            }
        }
    }
}
