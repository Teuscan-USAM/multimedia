@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Egresos</h1>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mt-3">
          <div>
            <h5 class="card-title mb-0">Departamento: {{ $departamento?->nombre ?? 'Sin asignar' }}</h5>
            <small class="text-muted">{{ $departamento?->iglesia?->nombre }}</small>
          </div>
          <a class="btn btn-primary" href="{{ route('egresos.create') }}">
            <i class="bi bi-plus"></i> Registrar egreso
          </a>
        </div>

        <div class="table-responsive">
          <table class="table table-striped datatable">
            <thead>
              <tr>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th class="text-end">Monto</th>
                <th class="text-end">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($items as $it)
                <tr>
                  <td>{{ \Illuminate\Support\Carbon::parse($it->fecha)->format('Y-m-d') }}</td>
                  <td>{{ $it->nombre }}</td>
                  <td>{{ $it->categoria?->nombre }}</td>
                  <td class="text-end">${{ number_format($it->monto, 2) }}</td>
                  <td class="text-end">
                    <a class="btn btn-sm btn-warning" href="{{ route('egresos.edit', $it->id) }}">Editar</a>
                    <form class="d-inline" method="POST" action="{{ route('egresos.destroy', $it->id) }}" onsubmit="return confirm('¿Eliminar este egreso?');">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection

