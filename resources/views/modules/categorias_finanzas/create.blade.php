@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Crear categoría</h1>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Datos</h5>

        <form method="POST" action="{{ route('categorias.store') }}">
          @csrf

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Tipo *</label>
              <select name="tipo" class="form-select" required>
                <option value="ingreso" @selected(old('tipo')==='ingreso')>Ingreso</option>
                <option value="egreso" @selected(old('tipo')==='egreso')>Egreso</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Nombre *</label>
              <input name="nombre" class="form-control" value="{{ old('nombre') }}" required>
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
            <a class="btn btn-secondary" href="{{ route('categorias.index') }}">Volver</a>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>
@endsection

