@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Iglesias</h1>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mt-3">
          <h5 class="card-title mb-0">Listado</h5>
          <a class="btn btn-primary" href="{{ route('iglesias.create') }}">
            <i class="bi bi-plus"></i> Nueva iglesia
          </a>
        </div>

        <div class="table-responsive">
          <table class="table table-striped datatable">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Ciudad</th>
                <th>Teléfono</th>
                <th>Responsable</th>
                <th class="text-end">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($items as $it)
                <tr>
                  <td>{{ $it->nombre }}</td>
                  <td>{{ $it->ciudad }}</td>
                  <td>{{ $it->telefono }}</td>
                  <td>{{ $it->responsable }}</td>
                  <td class="text-end">
                    <a class="btn btn-sm btn-warning" href="{{ route('iglesias.edit', $it->id) }}">Editar</a>
                    <form class="d-inline" method="POST" action="{{ route('iglesias.destroy', $it->id) }}" onsubmit="return confirm('¿Eliminar esta iglesia?');">
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

