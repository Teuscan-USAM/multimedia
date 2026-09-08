@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Reporte de {{ $mes->translatedFormat('F Y') }}</h1>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
          <div>
            <h5 class="card-title mb-1">Últimos movimientos</h5>
            <small class="text-muted">Generado por {{ $usuario->name }} · {{ $generadoEn->format('d/m/Y H:i') }}</small>
          </div>
          <div class="d-flex gap-2">
            <a class="btn btn-outline-secondary" href="{{ route('reportes.index') }}">Cambiar mes</a>
            <a class="btn btn-danger" href="{{ route('reportes.finanzas.pdf', ['mes' => $mes->format('Y-m')]) }}">Descargar PDF</a>
          </div>
        </div>

        <div class="row text-center my-3">
          <div class="col-md-4 mb-2">
            <div class="border rounded p-3">
              <div class="text-muted">Ingresos</div>
              <strong class="text-success">${{ number_format($totalIngresos, 2) }}</strong>
            </div>
          </div>
          <div class="col-md-4 mb-2">
            <div class="border rounded p-3">
              <div class="text-muted">Egresos</div>
              <strong class="text-danger">${{ number_format($totalEgresos, 2) }}</strong>
            </div>
          </div>
          <div class="col-md-4 mb-2">
            <div class="border rounded p-3">
              <div class="text-muted">Saldo</div>
              <strong class="{{ $saldo < 0 ? 'text-danger' : 'text-success' }}">${{ number_format($saldo, 2) }}</strong>
            </div>
          </div>
        </div>

        @forelse($porDepartamento as $bloque)
          <h6 class="mt-4">{{ $bloque['departamento']->nombre }}
            <small class="text-muted">({{ $bloque['departamento']->iglesia?->nombre }})</small>
          </h6>
          @if($usuario->rol === 'pastor' && $bloque['departamento']->miembro)
            <p class="text-muted mb-2">Miembro: {{ $bloque['departamento']->miembro->name }}</p>
          @endif

          <div class="table-responsive mb-3">
            <table class="table table-sm table-striped">
              <thead>
                <tr>
                  <th>Fecha</th>
                  <th>Tipo</th>
                  <th>Concepto</th>
                  <th>Categoría</th>
                  <th class="text-end">Monto</th>
                </tr>
              </thead>
              <tbody>
                @forelse($bloque['ingresos']->concat($bloque['egresos'])->sortByDesc(fn ($m) => $m->fecha->format('Y-m-d').$m->id) as $mov)
                  <tr>
                    <td>{{ $mov->fecha?->format('d/m/Y') }}</td>
                    <td>
                      @if($mov instanceof \App\Models\Ingreso)
                        <span class="badge bg-success">Ingreso</span>
                      @else
                        <span class="badge bg-danger">Egreso</span>
                      @endif
                    </td>
                    <td>{{ $mov->nombre }}</td>
                    <td>{{ $mov->categoria?->nombre }}</td>
                    <td class="text-end">${{ number_format($mov->monto, 2) }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-muted">Sin movimientos en este mes.</td>
                  </tr>
                @endforelse
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="4">Saldo del departamento</th>
                  <th class="text-end {{ $bloque['saldo'] < 0 ? 'text-danger' : 'text-success' }}">${{ number_format($bloque['saldo'], 2) }}</th>
                </tr>
              </tfoot>
            </table>
          </div>
        @empty
          <div class="alert alert-warning">No hay departamentos para este reporte.</div>
        @endforelse
      </div>
    </div>
  </section>
</main>
@endsection
