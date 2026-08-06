@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main d-flex justify-content-center align-items-center" style="min-height: 80vh;">
  <section class="section w-100" style="max-width: 600px;">
    <div class="card shadow-lg border-0 rounded-4">
      <div class="card-body p-4">
        <h2 class="card-title text-center mb-4 fw-bold text-primary">Mi Perfil</h2>

        {{-- ✅ MENSAJE DE ÉXITO --}}
        @if(session('success'))
          <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        {{-- ✅ FORMULARIO DE PERFIL --}}
        <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
          @csrf

          {{-- ✅ FOTO DE PERFIL --}}
          <div class="text-center mb-4">
            <label for="foto" class="form-label d-block fw-semibold">Foto de perfil</label>
            <div class="position-relative d-inline-block">
              <img src="{{ $usuario->foto ? asset('fotos_perfil/' . $usuario->foto) : asset('img/default.png') }}"
                alt="Foto de perfil"
                class="rounded-circle shadow"
                style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #0d6efd;">

            </div>
            <input type="file" name="foto" id="foto" class="form-control mt-3">
          </div>

          {{-- ✅ CAMPOS DE INFORMACIÓN DEL USUARIO --}}
          <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" 
                   value="{{ old('name', $usuario->name) }}" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Correo Electrónico</label>
            <input type="email" name="email" id="email" class="form-control" 
                   value="{{ old('email', $usuario->email) }}" required>
          </div>

          <div class="mb-3">
            <label for="rol" class="form-label fw-semibold">Rol</label>
            <input type="text" class="form-control" id="rol" 
                   value="{{ ucfirst($usuario->rol) }}" readonly>
          </div>

          <div class="mb-3">
            <label for="activo" class="form-label fw-semibold">Estado</label>
            <input type="text" class="form-control" 
                   value="{{ $usuario->activo ? 'Activo' : 'Inactivo' }}" readonly>
          </div>

          {{-- ✅ BOTÓN DE ACTUALIZAR --}}
          <div class="text-center">
            <button type="submit" class="btn btn-primary mt-3 px-4 py-2 rounded-pill">
              <i class="bi bi-save"></i> Actualizar Perfil
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>
@endsection
