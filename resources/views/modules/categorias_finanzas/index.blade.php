@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Categorías</h1>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mt-3">
          <h5 class="card-title mb-0">Listado de categorias por iglesia</h5>
          <a class="btn btn-primary" href="{{ route('categorias.create') }}">
            <i class="bi bi-plus"></i> Nueva categoría
          </a>
        </div>

        <div class="table-responsive">
          <table class="table table-striped datatable">
            <thead>
              <tr>
                <th>Iglesia</th>
                <th>Tipo</th>
                <th>Nombre</th>
                <th class="text-end">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($items as $it)
                <tr>
                  <td>{{ $it->iglesia?->nombre }}</td>
                  <td>{{ ucfirst($it->tipo) }}</td>
                  <td>{{ $it->nombre }}</td>
                  <td class="text-end">
                    <a class="btn btn-sm btn-warning" href="{{ route('categorias.edit', $it->id) }}">Editar</a>
                    <form class="d-inline" method="POST" action="{{ route('categorias.destroy', $it->id) }}" onsubmit="return confirm('¿Eliminar esta categoría?');">
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

