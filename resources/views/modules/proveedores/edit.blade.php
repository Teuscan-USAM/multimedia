@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Editar proveedor</h1>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Editar Proveedor</h5>

            <form action="{{ route('proveedores.update', $item->id) }}" method="POST">
              @csrf
              @method('PUT')

              {{-- Nombre --}}
              <label for="nombre">Nombre de proveedor</label>
              <input type="text" class="form-control @error('nombre') is-invalid @enderror" required name="nombre" id="nombre" value="{{ old('nombre', $item->nombre) }}">
              @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror

              {{-- Teléfono --}}
              <label for="telefono" class="mt-2">Teléfono</label>
              <input type="text" class="form-control @error('telefono') is-invalid @enderror" required name="telefono" id="telefono" value="{{ old('telefono', $item->telefono) }}">
              @error('telefono')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror

              {{-- Email --}}
              <label for="email" class="mt-2">Email</label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" required name="email" id="email" value="{{ old('email', $item->email) }}">
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror

              {{-- NIT (cp) --}}
              <label for="cp" class="mt-2">NIT</label>
              <input type="text" class="form-control @error('cp') is-invalid @enderror" required name="cp" id="cp" value="{{ old('cp', $item->cp) }}">
              @error('cp')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror

              {{-- Sitio Web (opcional) --}}
              <label for="sitio_web" class="mt-2">Sitio Web <small class="text-muted">(opcional)</small></label>
              <input type="text" class="form-control @error('sitio_web') is-invalid @enderror" name="sitio_web" id="sitio_web" value="{{ old('sitio_web', $item->sitio_web) }}">
              @error('sitio_web')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror

              {{-- Notas (opcional) --}}
              <label for="notas" class="mt-2">Notas <small class="text-muted">(opcional)</small></label>
              <textarea name="notas" id="notas" cols="30" rows="5" class="form-control @error('notas') is-invalid @enderror">{{ old('notas', $item->notas) }}</textarea>
              @error('notas')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror

              {{-- Botones --}}
              <button class="btn btn-warning mt-3">Actualizar</button>
              <a href="{{ route('proveedores') }}" class="btn btn-info mt-3">Cancelar</a>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
