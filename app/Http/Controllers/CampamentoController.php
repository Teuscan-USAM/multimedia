<?php

namespace App\Http\Controllers;

use App\Models\CampamentoInscripcion;
use App\Models\CtlDepartamento;
use App\Models\CtlMunicipio;
use App\Models\CtlDistrito;
use App\Models\DepartamentoCatalogo;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CampamentoController extends Controller
{
    public function create()
    {
        $departamentosCatalogo = DepartamentoCatalogo::query()
            ->orderBy('nombre')
            ->get();
        $departamentosTerritoriales = CtlDepartamento::query()
            ->with('municipios.distritos')
            ->orderBy('nombre')
            ->get();

        return view('campamento.formulario', [
            'departamentosCatalogo' => $departamentosCatalogo,
            'departamentosTerritoriales' => $departamentosTerritoriales,
            'inscripcion' => null,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_completo' => ['required', 'string', 'max:255'],
            'fecha_nacimiento' => ['required', 'date', 'before_or_equal:today'],
            'edad' => [
                'required',
                'integer',
                'min:0',
                'max:120',
                function (string $attribute, mixed $value, \Closure $fail) use ($request): void {
                    if ($request->filled('fecha_nacimiento')) {
                        $fechaNacimiento = $request->input('fecha_nacimiento');

                        if (! is_string($fechaNacimiento) || ! strtotime($fechaNacimiento)) {
                            return;
                        }

                        $edadCalculada = Carbon::parse($fechaNacimiento)->age;

                        if ((int) $value !== $edadCalculada) {
                            $fail("La edad no coincide con la fecha de nacimiento. La edad correcta es {$edadCalculada} años.");
                        }
                    }
                },
            ],
            'sexo' => ['required', 'string', 'in:Femenino,Masculino,Otro'],
            'telefono' => ['required', 'string', 'max:40'],
            'departamento_id' => ['required', 'integer', 'exists:ctl_departamento,id_departamento'],
            'municipio_id' => ['required', 'integer', 'exists:ctl_municipio,id_municipio'],
            'distrito_id' => ['required', 'integer', 'exists:ctl_distrito,id_distrito'],
            'pertenece_iglesia' => ['required', 'boolean'],
            'iglesia' => ['nullable', 'required_if:pertenece_iglesia,1', 'string', 'max:255'],
            'departamento_catalogo_id' => ['nullable', 'required_if:pertenece_iglesia,1', 'integer', 'exists:departamento_catalogo,id'],
            'primera_vez' => ['required', 'boolean'],
            'encargado_nombre' => ['required', 'string', 'max:255'],
            'encargado_telefono' => ['required', 'string', 'max:40'],
            'tiene_alergias' => ['required', 'boolean'],
            'alergias' => ['nullable', 'required_if:tiene_alergias,1', 'string', 'max:1000'],
        ]);

        $this->validateTerritorialSelection($data);

        unset($data['departamento_id'], $data['municipio_id']);

        if (! $data['pertenece_iglesia']) {
            $data['iglesia'] = null;
            $data['departamento_catalogo_id'] = null;
        }

        if (! $data['tiene_alergias']) {
            $data['alergias'] = null;
        }

        CampamentoInscripcion::create($data);

        return redirect()->route('campamento.formulario')
            ->with('success', 'Tu inscripción fue recibida correctamente. ¡Te esperamos en el campamento!');
    }

    public function index()
    {
        $inscripciones = CampamentoInscripcion::with([
            'departamentoCatalogo',
            'distrito.municipio.departamento',
        ])->latest()->get();
        $inscritosPorDia = $inscripciones
            ->groupBy(fn (CampamentoInscripcion $inscripcion) => $inscripcion->created_at->format('d/m/Y'))
            ->map->count()
            ->sortKeys();

        return view('modules.campamento.index', [
            'inscripciones' => $inscripciones,
            'total' => $inscripciones->count(),
            'menores' => $inscripciones->where('edad', '<', 18)->count(),
            'mujeres' => $inscripciones->where('sexo', 'Femenino')->count(),
            'hombres' => $inscripciones->where('sexo', 'Masculino')->count(),
            'sinSexo' => $inscripciones->whereNotIn('sexo', ['Femenino', 'Masculino'])->count(),
            'conIglesia' => $inscripciones->where('pertenece_iglesia', true)->count(),
            'sinIglesia' => $inscripciones->where('pertenece_iglesia', false)->count(),
            'conAlergias' => $inscripciones->where('tiene_alergias', true)->count(),
            'sinAlergias' => $inscripciones->where('tiene_alergias', false)->count(),
            'inscritosPorDia' => $inscritosPorDia,
        ]);
    }

    public function show(CampamentoInscripcion $inscripcion)
    {
        $inscripcion->load('distrito.municipio.departamento');

        return view('modules.campamento.show', compact('inscripcion'));
    }

    public function edit(CampamentoInscripcion $inscripcion)
    {
        $inscripcion->load('distrito.municipio');
        $departamentosCatalogo = DepartamentoCatalogo::query()->orderBy('nombre')->get();
        $departamentosTerritoriales = CtlDepartamento::query()
            ->with('municipios.distritos')
            ->orderBy('nombre')
            ->get();

        return view('campamento.formulario', compact(
            'inscripcion',
            'departamentosCatalogo',
            'departamentosTerritoriales'
        ));
    }

    public function update(Request $request, CampamentoInscripcion $inscripcion)
    {
        $data = $request->validate([
            'nombre_completo' => ['required', 'string', 'max:255'],
            'fecha_nacimiento' => ['required', 'date', 'before_or_equal:today'],
            'edad' => [
                'required',
                'integer',
                'min:0',
                'max:120',
                function (string $attribute, mixed $value, \Closure $fail) use ($request): void {
                    if ($request->filled('fecha_nacimiento')) {
                        $fechaNacimiento = $request->input('fecha_nacimiento');

                        if (! is_string($fechaNacimiento) || ! strtotime($fechaNacimiento)) {
                            return;
                        }

                        $edadCalculada = Carbon::parse($fechaNacimiento)->age;

                        if ((int) $value !== $edadCalculada) {
                            $fail("La edad no coincide con la fecha de nacimiento. La edad correcta es {$edadCalculada} años.");
                        }
                    }
                },
            ],
            'sexo' => ['required', 'string', 'in:Femenino,Masculino,Otro'],
            'telefono' => ['required', 'string', 'max:40'],
            'departamento_id' => ['required', 'integer', 'exists:ctl_departamento,id_departamento'],
            'municipio_id' => ['required', 'integer', 'exists:ctl_municipio,id_municipio'],
            'distrito_id' => ['required', 'integer', 'exists:ctl_distrito,id_distrito'],
            'pertenece_iglesia' => ['required', 'boolean'],
            'iglesia' => ['nullable', 'required_if:pertenece_iglesia,1', 'string', 'max:255'],
            'departamento_catalogo_id' => ['nullable', 'required_if:pertenece_iglesia,1', 'integer', 'exists:departamento_catalogo,id'],
            'primera_vez' => ['required', 'boolean'],
            'encargado_nombre' => ['required', 'string', 'max:255'],
            'encargado_telefono' => ['required', 'string', 'max:40'],
            'tiene_alergias' => ['required', 'boolean'],
            'alergias' => ['nullable', 'required_if:tiene_alergias,1', 'string', 'max:1000'],
        ]);

        $this->validateTerritorialSelection($data);

        unset($data['departamento_id'], $data['municipio_id']);
        if (! $data['pertenece_iglesia']) {
            $data['iglesia'] = null;
            $data['departamento_catalogo_id'] = null;
        }
        if (! $data['tiene_alergias']) {
            $data['alergias'] = null;
        }

        $inscripcion->update($data);

        return redirect()->route('campamento.show', $inscripcion)
            ->with('success', 'La inscripción fue actualizada correctamente.');
    }

    public function destroy(CampamentoInscripcion $inscripcion)
    {
        $inscripcion->delete();

        return redirect()->route('campamento.index')
            ->with('success', 'La inscripción fue eliminada correctamente.');
    }

    private function validateTerritorialSelection(array $data): void
    {
        $municipioPertenece = CtlMunicipio::query()
            ->where('id_municipio', $data['municipio_id'])
            ->where('id_departamento', $data['departamento_id'])
            ->exists();
        $distritoPertenece = CtlDistrito::query()
            ->where('id_distrito', $data['distrito_id'])
            ->where('id_municipio', $data['municipio_id'])
            ->exists();

        if (! $municipioPertenece || ! $distritoPertenece) {
            throw ValidationException::withMessages([
                'distrito_id' => 'El distrito seleccionado no pertenece al municipio y departamento indicados.',
            ]);
        }
    }

    public function allergiesPdf()
    {
        $inscripciones = CampamentoInscripcion::query()
            ->where('tiene_alergias', true)
            ->whereNotNull('alergias')
            ->where('alergias', '!=', '')
            ->with('distrito.municipio.departamento')
            ->orderBy('nombre_completo')
            ->get(['nombre_completo', 'edad', 'telefono', 'distrito_id', 'alergias']);

        return Pdf::loadView('modules.campamento.pdf.alergias', [
            'inscripciones' => $inscripciones,
            'generadoEn' => now(),
        ])->setPaper('letter', 'portrait')->stream('lista-de-alergias.pdf');
    }
}
