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
            <div class="col-md-6">
              <label class="form-label">Pastor responsable</label>
              <select name="pastor_id" class="form-select">
                <option value="">Sin pastor responsable</option>
                @foreach($pastores as $pastor)
                  <option value="{{ $pastor->id }}" @selected(old('pastor_id', $item->pastor_id) == $pastor->id)>{{ $pastor->name }} ({{ $pastor->email }})</option>
                @endforeach
              </select>
            </div>
            <div class="col-12">
              <label class="form-label">Dirección</label>
              <input name="direccion" class="form-control" value="{{ old('direccion', $item->direccion) }}">
            </div>
            <div class="col-12">
              <label class="form-label">Dirección de Google Maps</label>
              <input type="url" name="direccion_google_maps" class="form-control" value="{{ old('direccion_google_maps', $item->direccion_google_maps) }}" placeholder="Pega aquí el enlace de Google Maps">
              <div class="form-text">Pega el enlace de ubicación de Google Maps.</div>
            </div>
            <div class="col-12">
              <label class="form-label">Departamentos habilitados</label>
              <div class="border rounded p-3">
                @forelse($catalogo as $dep)
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="catalogo_ids[]" value="{{ $dep->id }}" id="cat-{{ $dep->id }}"
                      @checked(in_array($dep->id, old('catalogo_ids', $habilitados)))>
                    <label class="form-check-label" for="cat-{{ $dep->id }}">{{ $dep->nombre }}</label>
                  </div>
                @empty
                  <div class="text-muted">Aún no hay departamentos en el catálogo.</div>
                @endforelse
              </div>
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

