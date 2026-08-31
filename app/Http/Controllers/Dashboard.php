<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Egreso;
use App\Models\Iglesia;
use App\Models\Ingreso;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function index(){
        $titulo = 'Dashboard';

        $user = Auth::user();

        // Admin: métricas globales
        if ($user->rol === 'admin') {
            $stats = [
                'total_iglesias' => Iglesia::count(),
                'total_pastores' => User::where('rol', 'pastor')->count(),
                'total_departamentos' => Departamento::count(),
                'total_usuarios' => User::count(),
            ];

            return view('modules.dashboard.home', compact('titulo', 'stats'));
        }

        // Pastor: solo sus iglesias y departamentos
        if ($user->rol === 'pastor') {
            $iglesias = $user->iglesiasPastor()->with('departamentos')->get();
            $departamentos = Departamento::where('pastor_id', $user->id)->get();

            $resumen = $departamentos->map(function (Departamento $d) {
                $ingresos = Ingreso::where('departamento_id', $d->id)->sum('monto');
                $egresos = Egreso::where('departamento_id', $d->id)->sum('monto');
                return [
                    'departamento' => $d,
                    'ingresos' => $ingresos,
                    'egresos' => $egresos,
                    'saldo' => $ingresos - $egresos,
                ];
            });

            return view('modules.dashboard.home', compact('titulo', 'iglesias', 'resumen'));
        }

        // Miembro: solo su departamento
        $departamento = Departamento::where('miembro_id', $user->id)->first();

        if ($departamento) {
            $ingresosPorMes = Ingreso::where('departamento_id', $departamento->id)
                ->orderBy('fecha')
                ->get()
                ->groupBy(fn ($item) => $item->fecha->format('Y-m'));

            $egresosPorMes = Egreso::where('departamento_id', $departamento->id)
                ->orderBy('fecha')
                ->get()
                ->groupBy(fn ($item) => $item->fecha->format('Y-m'));

            $saldo = Ingreso::where('departamento_id', $departamento->id)->sum('monto')
                - Egreso::where('departamento_id', $departamento->id)->sum('monto');
        } else {
            $ingresosPorMes = collect();
            $egresosPorMes = collect();
            $saldo = 0;
        }

        return view('modules.dashboard.home', compact(
            'titulo',
            'departamento',
            'saldo',
            'ingresosPorMes',
            'egresosPorMes'
        ));
    }
}
