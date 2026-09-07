@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Habilitar departamentos</h1>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mt-3">
          <h5 class="card-title mb-0">Un check por iglesia</h5>
          <a class="btn btn-secondary" href="{{ route('catalogo-departamentos.index') }}">Volver al catálogo</a>
        </div>
        <p class="text-muted">Marca los departamentos del catálogo que cada iglesia puede usar. El pastor solo podrá asignar los habilitados.</p>

        @if($catalogo->isEmpty())
          <div class="alert alert-warning">Primero crea departamentos en el catálogo.</div>
        @endif

        <form method="POST" action="{{ route('catalogo-departamentos.habilitaciones.guardar') }}">
          @csrf

          @forelse($iglesias as $ig)
            @php
              $ids = $ig->departamentos->pluck('catalogo_id')->all();
            @endphp
            <div class="border rounded p-3 mb-3">
              <h6 class="mb-2">{{ $ig->nombre }}</h6>
              @foreach($catalogo as $dep)
                <div class="form-check">
                  <input class="form-check-input" type="checkbox"
                    name="habilitados[{{ $ig->id }}][]"
                    value="{{ $dep->id }}"
                    id="ig-{{ $ig->id }}-dep-{{ $dep->id }}"
                    @checked(in_array($dep->id, old('habilitados.'.$ig->id, $ids)))>
                  <label class="form-check-label" for="ig-{{ $ig->id }}-dep-{{ $dep->id }}">{{ $dep->nombre }}</label>
                </div>
              @endforeach
            </div>
          @empty
            <div class="text-muted">No hay iglesias registradas.</div>
          @endforelse

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
            <button class="btn btn-primary" type="submit" @disabled($iglesias->isEmpty() || $catalogo->isEmpty())>Guardar habilitaciones</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>
@endsection
