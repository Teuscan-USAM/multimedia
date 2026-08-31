<!DOCTYPE html>
<html>
<head>
    <title>Página de Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">TEO</a>

    <div class="dropdown ms-auto">
      <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
        Sing in
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <a class="dropdown-item" href="{{ route('login') }}">
            Iniciar Sesión
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- CONTENIDO -->
<div class="container mt-5">
    <h1 class="text-center mb-4">   Agregar aqui los anuncios y publicaciones</h1>

    <div class="row">
        @foreach($anuncios as $anuncio)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    
                    @if($anuncio->imagen)
                        <img src="{{ asset('storage/'.$anuncio->imagen) }}" 
                             class="card-img-top" 
                             style="height:200px; object-fit:cover;">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $anuncio->titulo }}</h5>
                        <p class="card-text flex-grow-1">{{ $anuncio->descripcion }}</p>
                        <small class="text-muted mt-2">
                            Publicado: {{ $anuncio->created_at ? $anuncio->created_at->format('d/m/Y') : 'Hoy' }}
                        </small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>