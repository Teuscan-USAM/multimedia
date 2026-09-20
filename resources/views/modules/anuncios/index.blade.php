@extends('layouts.main')

@section('titulo', 'Anuncios')

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle d-flex justify-content-between align-items-center">
    <div><h1>Anuncios</h1><p>Publicaciones visibles en la página pública de Jóvenes.</p></div>
    <a href="{{ route('anuncios.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Nuevo anuncio</a>
  </div>
  <section class="section">
    <div class="card"><div class="card-body pt-3">
      <div class="table-responsive">
        <table class="table datatable align-middle">
          <thead><tr><th>Título</th><th>Imagen</th><th>Estado</th><th>Fecha</th><th></th></tr></thead>
          <tbody>
            @foreach($anuncios as $anuncio)
              <tr>
                <td><strong>{{ $anuncio->titulo }}</strong><br><small>{{ Str::limit($anuncio->descripcion, 90) }}</small></td>
                <td>@if($anuncio->imagen)<img src="{{ route('anuncios.image', $anuncio) }}" alt="" width="72" height="48" style="object-fit:cover">@else Sin foto @endif</td>
                <td><span class="badge {{ $anuncio->estado ? 'bg-success' : 'bg-secondary' }}">{{ $anuncio->estado ? 'Publicado' : 'Oculto' }}</span></td>
                <td>{{ $anuncio->created_at?->format('d/m/Y') }}</td>
                <td><form action="{{ route('anuncios.destroy', $anuncio) }}" method="POST" onsubmit="return confirm('¿Eliminar este anuncio?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" type="submit"><i class="bi bi-trash"></i></button></form></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div></div>
  </section>
</main>
@endsection