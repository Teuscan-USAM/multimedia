@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Catálogo de departamentos</h1>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mt-3">
          <h5 class="card-title mb-0">Departamentos estándar</h5>
          <div class="d-flex gap-2">
            <a class="btn btn-outline-primary" href="{{ route('catalogo-departamentos.habilitaciones') }}">
              Habilitar por iglesia
            </a>
            <a class="btn btn-primary" href="{{ route('catalogo-departamentos.create') }}">
              <i class="bi bi-plus"></i> Nuevo departamento
            </a>
          </div>
        </div>
        <p class="text-muted">Solo el administrador crea el catálogo. Luego se habilita por iglesia con un check.</p>

        <div class="table-responsive">
          <table class="table table-striped datatable">
            <thead>
              <tr>
                <th>Departamento</th>
                <th>Descripción</th>
                <th>Iglesias habilitadas</th>
                <th class="text-end">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($items as $it)
                <tr>
                  <td>{{ $it->nombre }}</td>
                  <td>{{ $it->descripcion }}</td>
                  <td>{{ $it->iglesias_habilitadas_count }}</td>
                  <td class="text-end">
                    <a class="btn btn-sm btn-warning" href="{{ route('catalogo-departamentos.edit', $it->id) }}">Editar</a>
                    <form class="d-inline" method="POST" action="{{ route('catalogo-departamentos.destroy', $it->id) }}" onsubmit="return confirm('¿Eliminar este departamento del catálogo?');">
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
