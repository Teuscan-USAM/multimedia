<?php

namespace App\Http\Controllers;

use App\Models\CategoriaFinanza;
use App\Models\Departamento;
use App\Models\DepartamentoCatalogo;
use App\Models\Egreso;
use App\Models\Iglesia;
use App\Models\Ingreso;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ReportesController extends Controller
{
    public function index(Request $request)
    {
        $titulo = 'Reportes';
        $user = Auth::user();
        $mes = $this->mesSeleccionado($request);

        if ($user->rol === 'admin') {
            return view('modules.reportes.index', compact('titulo'));
        }

        $departamentos = $this->departamentosDelUsuario($user);

        return view('modules.reportes.index', compact('titulo', 'mes', 'departamentos'));
    }

    public function finanzas(Request $request)
    {
        $this->autorizarFinanzas();

        $titulo = 'Reporte de movimientos';
        $datos = $this->datosFinanzas($request);

        return view('modules.reportes.finanzas', $datos + ['titulo' => $titulo]);
    }

    public function finanzasPdf(Request $request)
    {
        $this->autorizarFinanzas();

        $datos = $this->datosFinanzas($request);
        $nombre = 'reporte-movimientos-'.$datos['mes']->format('Y-m').'.pdf';

        return Pdf::loadView('modules.reportes.pdf.finanzas', $datos)
            ->setPaper('letter', 'portrait')
            ->download($nombre);
    }

    public function categorias()
    {
        $this->autorizarAdmin();

        $items = CategoriaFinanza::query()->orderBy('tipo')->orderBy('nombre')->get();

        return Pdf::loadView('modules.reportes.pdf.categorias', [
            'titulo' => 'Reporte de categorías',
            'generadoEn' => now(),
            'usuario' => Auth::user(),
            'items' => $items,
        ])->setPaper('letter')->download('reporte-categorias.pdf');
    }

    public function departamentos()
    {
        $this->autorizarAdmin();

        $items = DepartamentoCatalogo::query()
            ->with(['departamentos' => function ($query) {
                $query->where('habilitado', true)->with(['iglesia', 'miembro']);
            }])
            ->orderBy('nombre')
            ->get();

        return Pdf::loadView('modules.reportes.pdf.departamentos', [
            'titulo' => 'Reporte de departamentos',
            'generadoEn' => now(),
            'usuario' => Auth::user(),
            'items' => $items,
        ])->setPaper('letter')->download('reporte-departamentos.pdf');
    }

    public function iglesias()
    {
        $this->autorizarAdmin();

        $items = Iglesia::query()
            ->with(['pastorResponsable', 'departamentosHabilitados.catalogo'])
            ->withCount(['departamentos as departamentos_habilitados_count' => function ($query) {
                $query->where('habilitado', true);
            }])
            ->orderBy('nombre')
            ->get();

        return Pdf::loadView('modules.reportes.pdf.iglesias', [
            'titulo' => 'Reporte de iglesias',
            'generadoEn' => now(),
            'usuario' => Auth::user(),
            'items' => $items,
        ])->setPaper('letter')->download('reporte-iglesias.pdf');
    }

    private function autorizarFinanzas(): void
    {
        abort_unless(in_array(Auth::user()->rol, ['pastor', 'miembro'], true), 403);
    }

    private function autorizarAdmin(): void
    {
        abort_unless(Auth::user()->rol === 'admin', 403);
    }

    private function mesSeleccionado(Request $request): Carbon
    {
        $valor = $request->string('mes')->toString();

        try {
            $mes = $valor !== ''
                ? Carbon::createFromFormat('Y-m', $valor)->startOfMonth()
                : now()->startOfMonth();
        } catch (\Throwable) {
            $mes = now()->startOfMonth();
        }

        return $mes->locale('es');
    }

    /**
     * @return Collection<int, Departamento>
     */
    private function departamentosDelUsuario(User $user): Collection
    {
        if ($user->rol === 'miembro') {
            return Departamento::query()
                ->where('miembro_id', $user->id)
                ->with('iglesia')
                ->get();
        }

        $iglesiaIds = $user->iglesiasPastor()->pluck('iglesias.id');

        return Departamento::habilitados()
            ->whereIn('iglesia_id', $iglesiaIds)
            ->with('iglesia', 'miembro')
            ->get()
            ->sortBy(fn (Departamento $d) => ($d->iglesia?->nombre ?? '').' '.$d->nombre)
            ->values();
    }

    private function datosFinanzas(Request $request): array
    {
        $user = Auth::user();
        $mes = $this->mesSeleccionado($request);
        $inicio = $mes->copy()->startOfMonth();
        $fin = $mes->copy()->endOfMonth();
        $departamentos = $this->departamentosDelUsuario($user);
        $departamentoIds = $departamentos->pluck('id');

        $ingresos = Ingreso::query()
            ->whereIn('departamento_id', $departamentoIds)
            ->whereBetween('fecha', [$inicio->toDateString(), $fin->toDateString()])
            ->select(['id', 'departamento_id', 'categoria_id', 'nombre', 'monto', 'fecha'])
            ->with('categoria')
            ->orderByDesc('fecha')
            ->orderByDesc('id')
            ->get();

        $egresos = Egreso::query()
            ->whereIn('departamento_id', $departamentoIds)
            ->whereBetween('fecha', [$inicio->toDateString(), $fin->toDateString()])
            ->select(['id', 'departamento_id', 'categoria_id', 'nombre', 'monto', 'fecha'])
            ->with('categoria')
            ->orderByDesc('fecha')
            ->orderByDesc('id')
            ->get();

        $ingresosPorDepartamento = $ingresos->groupBy('departamento_id');
        $egresosPorDepartamento = $egresos->groupBy('departamento_id');

        $porDepartamento = $departamentos->map(function (Departamento $departamento) use ($ingresosPorDepartamento, $egresosPorDepartamento) {
            $ingresosDepto = $ingresosPorDepartamento->get($departamento->id, collect());
            $egresosDepto = $egresosPorDepartamento->get($departamento->id, collect());
            $totalIngresos = (float) $ingresosDepto->sum('monto');
            $totalEgresos = (float) $egresosDepto->sum('monto');

            return [
                'departamento' => $departamento,
                'ingresos' => $ingresosDepto,
                'egresos' => $egresosDepto,
                'total_ingresos' => $totalIngresos,
                'total_egresos' => $totalEgresos,
                'saldo' => $totalIngresos - $totalEgresos,
            ];
        });

        return [
            'mes' => $mes,
            'usuario' => $user,
            'generadoEn' => now(),
            'departamentos' => $departamentos,
            'porDepartamento' => $porDepartamento,
            'totalIngresos' => (float) $ingresos->sum('monto'),
            'totalEgresos' => (float) $egresos->sum('monto'),
            'saldo' => (float) $ingresos->sum('monto') - (float) $egresos->sum('monto'),
        ];
    }
}
