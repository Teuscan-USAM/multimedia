@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Editar iglesia</h1>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Datos</h5>

        <form method="POST" action="{{ route('iglesias.update', $item->id) }}">
          @csrf
          @method('PUT')

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nombre *</label>
              <input name="nombre" class="form-control" value="{{ old('nombre', $item->nombre) }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Ciudad</label>
              <input name="ciudad" class="form-control" value="{{ old('ciudad', $item->ciudad) }}">
            </div>
            <div class="col-md-6">
              <label class="form-label">Teléfono</label>
              <input name="telefono" class="form-control" value="{{ old('telefono', $item->telefono) }}">
            </div>
            <div class="col-md-6">
              <label class="form-label">Responsable</label>
              <input name="responsable" class="form-control" value="{{ old('responsable', $item->responsable) }}">
            </div>
            <div class="col-12">
              <label class="form-label">Dirección</label>
              <input name="direccion" class="form-control" value="{{ old('direccion', $item->direccion) }}">
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
            <button class="btn btn-primary" type="submit">Actualizar</button>
            <a class="btn btn-secondary" href="{{ route('iglesias.index') }}">Volver</a>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>
@endsection

