@extends('layouts.main')

@section('titulo', 'Nuevo anuncio')

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle"><h1>Nuevo anuncio</h1><p>Comparte una actividad o recuerdo con Jóvenes.</p></div>
  <section class="section"><div class="card"><div class="card-body pt-4">
    <form action="{{ route('anuncios.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row g-3">
        <div class="col-12"><label class="form-label" for="titulo">Título</label><input class="form-control" id="titulo" name="titulo" value="{{ old('titulo') }}" required>@error('titulo')<small class="text-danger">{{ $message }}</small>@enderror</div>
        <div class="col-12"><label class="form-label" for="descripcion">Descripción</label><textarea class="form-control" id="descripcion" name="descripcion" rows="5">{{ old('descripcion') }}</textarea></div>
        <div class="col-md-8"><label class="form-label" for="imagen">Fotografía</label><input class="form-control" id="imagen" name="imagen" type="file" accept="image/jpeg,image/png,image/webp"><small class="text-muted">JPG, PNG o WebP. Máximo 5 MB.</small>@error('imagen')<small class="d-block text-danger">{{ $message }}</small>@enderror</div>
        <div class="col-md-4 d-flex align-items-end"><div class="form-check form-switch mb-2"><input class="form-check-input" id="estado" name="estado" value="1" type="checkbox" checked><label class="form-check-label" for="estado">Publicar ahora</label></div></div>
      </div>
      <div class="mt-4"><button class="btn btn-primary" type="submit"><i class="bi bi-cloud-arrow-up"></i> Publicar anuncio</button> <a class="btn btn-light" href="{{ route('anuncios.index') }}">Cancelar</a></div>
    </form>
  </div></div></section>
</main>
@endsection