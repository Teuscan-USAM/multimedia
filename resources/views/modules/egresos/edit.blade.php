@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Editar egreso</h1>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Departamento: {{ $departamento->nombre }}</h5>

        <form method="POST" action="{{ route('egresos.update', $item->id) }}">
          @csrf
          @method('PUT')

          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Fecha *</label>
              <input type="date" name="fecha" class="form-control" value="{{ old('fecha', \Illuminate\Support\Carbon::parse($item->fecha)->format('Y-m-d')) }}" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Categoría *</label>
              <select name="categoria_id" class="form-select" required>
                @foreach($categorias as $c)
                  <option value="{{ $c->id }}" @selected(old('categoria_id', $item->categoria_id)==$c->id)>{{ $c->nombre }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Monto *</label>
              <input name="monto" type="number" step="0.01" class="form-control" value="{{ old('monto', $item->monto) }}" required>
            </div>
            <div class="col-12">
              <label class="form-label">Nombre *</label>
              <input name="nombre" class="form-control" value="{{ old('nombre', $item->nombre) }}" required>
            </div>
            <div class="col-12">
              <label class="form-label">Descripción</label>
              <input name="descripcion" class="form-control" value="{{ old('descripcion', $item->descripcion) }}">
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
            <a class="btn btn-secondary" href="{{ route('egresos.index') }}">Volver</a>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>
@endsection

