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
        $ultimosIngresos = $departamento
            ? Ingreso::where('departamento_id', $departamento->id)->orderByDesc('fecha')->take(5)->get()
            : collect();
        $ultimosEgresos = $departamento
            ? Egreso::where('departamento_id', $departamento->id)->orderByDesc('fecha')->take(5)->get()
            : collect();

        $saldo = 0;
        if ($departamento) {
            $ing = Ingreso::where('departamento_id', $departamento->id)->sum('monto');
            $egr = Egreso::where('departamento_id', $departamento->id)->sum('monto');
            $saldo = $ing - $egr;
        }

        return view('modules.dashboard.home', compact('titulo', 'departamento', 'saldo', 'ultimosIngresos', 'ultimosEgresos'));
    }
}
