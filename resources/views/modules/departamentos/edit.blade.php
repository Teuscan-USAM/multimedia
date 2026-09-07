@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Asignar departamento</h1>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">{{ $item->nombre }} — {{ $item->iglesia?->nombre }}</h5>

        <form method="POST" action="{{ route('departamentos.update', $item->id) }}">
          @csrf
          @method('PUT')

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Departamento</label>
              <input class="form-control" value="{{ $item->nombre }}" disabled>
            </div>
            <div class="col-md-6">
              <label class="form-label">Iglesia</label>
              <input class="form-control" value="{{ $item->iglesia?->nombre }}" disabled>
            </div>
            <div class="col-12">
              @if($pastorResponsable)
                <div class="alert alert-info mb-0">
                  Pastor responsable: <strong>{{ $pastorResponsable->name }}</strong>
                </div>
              @else
                <div class="alert alert-warning mb-0">
                  La iglesia no tiene pastor responsable configurado. No se puede asignar un miembro todavía.
                </div>
              @endif
            </div>
            <div class="col-12">
              <label class="form-label">Asignar miembro (opcional)</label>
              <select name="miembro_id" class="form-select">
                <option value="">Sin asignar</option>
                @foreach($miembros as $m)
                  <option value="{{ $m->id }}" @selected(old('miembro_id',$item->miembro_id)==$m->id)>{{ $m->name }} ({{ $m->email }})</option>
                @endforeach
              </select>
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
            <button class="btn btn-primary" type="submit">Guardar asignación</button>
            <a class="btn btn-secondary" href="{{ route('departamentos.index') }}">Volver</a>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>
@endsection
