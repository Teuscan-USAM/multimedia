@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Dashboard</h1>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Bienvenido, {{ Auth::user()->name }}!</h5>

            @if(Auth::user()->rol === 'admin')
              <div class="row text-center mb-4">
                <div class="col-md-3 mb-3">
                  <div class="bg-primary text-white rounded p-3 shadow-sm">
                    <h6 class="mb-1">Iglesias</h6>
                    <h4 class="mb-0">{{ $stats['total_iglesias'] ?? 0 }}</h4>
                  </div>
                </div>
                <div class="col-md-3 mb-3">
                  <div class="bg-success text-white rounded p-3 shadow-sm">
                    <h6 class="mb-1">Pastores</h6>
                    <h4 class="mb-0">{{ $stats['total_pastores'] ?? 0 }}</h4>
                  </div>
                </div>
                <div class="col-md-3 mb-3">
                  <div class="bg-info text-white rounded p-3 shadow-sm">
                    <h6 class="mb-1">Departamentos</h6>
                    <h4 class="mb-0">{{ $stats['total_departamentos'] ?? 0 }}</h4>
                  </div>
                </div>
                <div class="col-md-3 mb-3">
                  <div class="bg-secondary text-white rounded p-3 shadow-sm">
                    <h6 class="mb-1">Usuarios</h6>
                    <h4 class="mb-0">{{ $stats['total_usuarios'] ?? 0 }}</h4>
                  </div>
                </div>
              </div>
            @elseif(Auth::user()->rol === 'pastor')
              <div class="mb-3">
                <h6 class="mb-2">Mis iglesias</h6>
                <ul class="list-group">
                  @forelse(($iglesias ?? []) as $ig)
                    <li class="list-group-item d-flex justify-content-between">
                      <span>{{ $ig->nombre }}</span>
                      <span class="text-muted">{{ $ig->departamentos->count() }} deptos.</span>
                    </li>
                  @empty
                    <li class="list-group-item text-muted">No tienes iglesias asignadas.</li>
                  @endforelse
                </ul>
              </div>

              <h6 class="mb-2">Resumen por departamento</h6>
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Departamento</th>
                      <th class="text-end">Ingresos</th>
                      <th class="text-end">Egresos</th>
                      <th class="text-end">Saldo</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse(($resumen ?? []) as $row)
                      <tr>
                        <td>{{ $row['departamento']->nombre }}</td>
                        <td class="text-end">${{ number_format($row['ingresos'], 2) }}</td>
                        <td class="text-end">${{ number_format($row['egresos'], 2) }}</td>
                        <td class="text-end">${{ number_format($row['saldo'], 2) }}</td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="4" class="text-muted">No hay departamentos aún.</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            @else
              <div class="row text-center mb-4">
                <div class="col-md-6 mb-3">
                  <div class="bg-info text-white rounded p-3 shadow-sm">
                    <h6 class="mb-1">Mi departamento</h6>
                    <h4 class="mb-0">{{ $departamento?->nombre ?? 'Sin asignar' }}</h4>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="bg-success text-white rounded p-3 shadow-sm">
                    <h6 class="mb-1">Saldo actual</h6>
                    <h4 class="mb-0">${{ number_format($saldo ?? 0, 2) }}</h4>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <h6>Últimos ingresos</h6>
                  <ul class="list-group mb-3">
                    @forelse(($ultimosIngresos ?? []) as $it)
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $it->nombre }}
                        <span class="badge bg-success">${{ number_format($it->monto, 2) }}</span>
                      </li>
                    @empty
                      <li class="list-group-item text-muted">Sin ingresos</li>
                    @endforelse
                  </ul>
                </div>
                <div class="col-md-6">
                  <h6>Últimos egresos</h6>
                  <ul class="list-group mb-3">
                    @forelse(($ultimosEgresos ?? []) as $it)
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $it->nombre }}
                        <span class="badge bg-danger">${{ number_format($it->monto, 2) }}</span>
                      </li>
                    @empty
                      <li class="list-group-item text-muted">Sin egresos</li>
                    @endforelse
                  </ul>
                </div>
              </div>
            @endif

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection


