@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Reportes</h1>
  </div>

  <section class="section">
    @if(Auth::user()->rol === 'admin')
      <div class="row">
        <div class="col-md-4 mb-3">
          <a href="{{ route('reportes.categorias') }}" class="text-decoration-none">
            <div class="card h-100 text-center border-0" style="background:#4154f1;color:#fff;">
              <div class="card-body py-5">
                <i class="bi bi-tags fs-1 d-block mb-3"></i>
                <h4 class="mb-0">Categorías</h4>
                <small>Descargar reporte PDF</small>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-4 mb-3">
          <a href="{{ route('reportes.departamentos') }}" class="text-decoration-none">
            <div class="card h-100 text-center border-0" style="background:#2eca6a;color:#fff;">
              <div class="card-body py-5">
                <i class="bi bi-diagram-3 fs-1 d-block mb-3"></i>
                <h4 class="mb-0">Departamentos</h4>
                <small>Descargar reporte PDF</small>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-4 mb-3">
          <a href="{{ route('reportes.iglesias') }}" class="text-decoration-none">
            <div class="card h-100 text-center border-0" style="background:#ff771d;color:#fff;">
              <div class="card-body py-5">
                <i class="bi bi-building fs-1 d-block mb-3"></i>
                <h4 class="mb-0">Iglesias</h4>
                <small>Descargar reporte PDF</small>
              </div>
            </div>
          </a>
        </div>
      </div>
    @else
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Movimientos del mes</h5>
          @if(Auth::user()->rol === 'miembro')
            <p class="text-muted">Se genera el reporte solo de tu departamento asignado.</p>
          @else
            <p class="text-muted">Se genera el reporte de todos los departamentos habilitados en tus iglesias.</p>
          @endif

          @if(($departamentos ?? collect())->isEmpty())
            <div class="alert alert-warning">No tienes un departamento asignado para reportar.</div>
          @else
            <form method="GET" action="{{ route('reportes.finanzas') }}" class="row g-3 align-items-end">
              <div class="col-md-4">
                <label class="form-label">Mes</label>
                <input type="month" name="mes" class="form-control" value="{{ ($mes ?? now())->format('Y-m') }}" required>
              </div>
              <div class="col-md-8 d-flex gap-2">
                <button class="btn btn-primary" type="submit">Ver reporte</button>
                <button class="btn btn-outline-danger" type="submit" formaction="{{ route('reportes.finanzas.pdf') }}">Descargar PDF</button>
              </div>
            </form>
          @endif
        </div>
      </div>
    @endif
  </section>
</main>
@endsection
