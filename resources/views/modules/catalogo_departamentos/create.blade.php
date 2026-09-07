@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Nuevo departamento</h1>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Catálogo global</h5>

        <form method="POST" action="{{ route('catalogo-departamentos.store') }}">
          @csrf

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nombre *</label>
              <input name="nombre" class="form-control" value="{{ old('nombre') }}" required>
            </div>
            <div class="col-12">
              <label class="form-label">Descripción</label>
              <input name="descripcion" class="form-control" value="{{ old('descripcion') }}">
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
            <a class="btn btn-secondary" href="{{ route('catalogo-departamentos.index') }}">Volver</a>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>
@endsection
