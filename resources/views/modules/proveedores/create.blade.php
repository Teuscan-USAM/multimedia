@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle d-flex justify-content-between align-items-center">
    <h1>Gestión de Usuarios</h1>
    <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
      <i class="bi bi-person-plus"></i> Agregar Usuario
    </a>
  </div><!-- End Page Title -->

  <section class="section mt-3">
    <div class="row">
      <div class="col-lg-12">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Listado de Usuarios</h5>

            {{-- Mensaje de éxito --}}
            @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif

            {{-- Tabla de usuarios --}}
            <div class="table-responsive">
              <table class="table table-striped align-middle">
                <thead class="table-primary text-center">
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($usuarios as $usuario)
                    <tr>
                      <td class="text-center">{{ $loop->iteration }}</td>
                      <td>{{ $usuario->name }}</td>
                      <td>{{ $usuario->email }}</td>
                      <td>
                        @if($usuario->rol == 'admin')
                          <span class="badge bg-danger">Admin</span>
                        @elseif($usuario->rol == 'cajero')
                          <span class="badge bg-success">Cajero</span>
                        @elseif($usuario->rol == 'bodeguero')
                          <span class="badge bg-warning text-dark">Bodeguero</span>
                        @else
                          <span class="badge bg-secondary">Sin rol</span>
                        @endif
                      </td>
                      <td class="text-center">
                        <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-info">
                          <i class="bi bi-pencil"></i> Editar
                        </a>

                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Deseas eliminar este usuario?')">
                            <i class="bi bi-trash"></i> Eliminar
                          </button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="5" class="text-center text-muted">No hay usuarios registrados.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            {{-- Paginación (si aplica) --}}
            @if(method_exists($usuarios, 'links'))
              <div class="mt-3">
                {{ $usuarios->links() }}
              </div>
            @endif

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
