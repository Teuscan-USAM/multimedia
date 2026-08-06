@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Usuarios</h1>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mt-3">
          <h5 class="card-title mb-0">Listado</h5>
          <a class="btn btn-primary" href="{{ route('usuarios.create') }}">
            <i class="bi bi-plus"></i> Nuevo usuario
          </a>
        </div>

        <div class="table-responsive">
          <table class="table table-striped datatable">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Activo</th>
                <th class="text-end">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($items as $it)
                <tr>
                  <td>{{ $it->name }}</td>
                  <td>{{ $it->email }}</td>
                  <td>{{ ucfirst($it->rol) }}</td>
                  <td>
                    @if($it->activo)
                      <span class="badge bg-success">Sí</span>
                    @else
                      <span class="badge bg-danger">No</span>
                    @endif
                  </td>
                  <td class="text-end">
                    <a class="btn btn-sm btn-warning" href="{{ route('usuarios.edit', $it->id) }}">Editar</a>
                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('usuarios.estado', [$it->id, $it->activo ? 0 : 1]) }}">
                      {{ $it->activo ? 'Desactivar' : 'Activar' }}
                    </a>
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

