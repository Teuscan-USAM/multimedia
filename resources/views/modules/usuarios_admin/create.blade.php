@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Crear usuario</h1>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Datos</h5>

        <form method="POST" action="{{ route('usuarios.store') }}">
          @csrf

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nombre *</label>
              <input name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Email *</label>
              <input name="email" type="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Contraseña *</label>
              <input name="password" type="password" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Rol *</label>
              <select name="rol" class="form-select" required>
                <option value="admin" @selected(old('rol')==='admin')>Administrador</option>
                <option value="pastor" @selected(old('rol')==='pastor')>Pastor</option>
                <option value="miembro" @selected(old('rol','miembro')==='miembro')>Miembro</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label">Asignar iglesias (solo Pastor)</label>
              <select name="iglesias[]" class="form-select" multiple>
                @foreach($iglesias as $ig)
                  <option value="{{ $ig->id }}">{{ $ig->nombre }}</option>
                @endforeach
              </select>
              <small class="text-muted">Puedes seleccionar varias manteniendo Ctrl.</small>
            </div>
          </div>

          @if($errors->any())
            <div class="alert alert-danger mt-3">
              <ul class="mb-0">
                @foreach($errors->all() as $e)
                  <li>{{ $e }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="mt-3 d-flex gap-2">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <a class="btn btn-secondary" href="{{ route('usuarios.index') }}">Volver</a>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>
@endsection

