@extends('layouts.main')

@section('titulo', 'Ficha de inscripción')

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle d-flex justify-content-between align-items-center">
    <div><h1>Ficha de inscripción</h1><p>{{ $inscripcion->nombre_completo }}</p></div>
    <div class="d-flex gap-2">
      <a class="btn btn-outline-primary" href="{{ route('campamento.edit', $inscripcion) }}">Editar</a>
      <form method="POST" action="{{ route('campamento.destroy', $inscripcion) }}" onsubmit="return confirm('¿Deseas eliminar esta inscripción? Esta acción no se puede deshacer.');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-outline-danger">Eliminar</button>
      </form>
      <a class="btn btn-outline-secondary" href="{{ route('campamento.index') }}">Volver al listado</a>
    </div>
  </div>
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  <section class="section">
    <div class="card"><div class="card-body">
      <h5 class="card-title">Datos del participante</h5>
      <div class="row g-3">
        <div class="col-md-6"><strong>Nombre completo</strong><br>{{ $inscripcion->nombre_completo }}</div>
        <div class="col-md-3"><strong>Fecha de nacimiento</strong><br>{{ $inscripcion->fecha_nacimiento?->format('d/m/Y') }}</div>
        <div class="col-md-3"><strong>Edad</strong><br>{{ $inscripcion->edad }} años</div>
        <div class="col-md-3"><strong>Sexo</strong><br>{{ $inscripcion->sexo ?: 'No indicado' }}</div>
        <div class="col-md-3"><strong>Teléfono</strong><br>{{ $inscripcion->telefono }}</div>
        <div class="col-md-6"><strong>Departamento de residencia</strong><br>{{ $inscripcion->distrito?->municipio?->departamento?->nombre ?? 'No indicado' }}</div>
        <div class="col-md-6"><strong>Municipio de residencia</strong><br>{{ $inscripcion->distrito?->municipio?->nombre ?? 'No indicado' }}</div>
        <div class="col-md-6"><strong>Distrito de residencia</strong><br>{{ $inscripcion->distrito?->nombre ?? 'No indicado' }}</div>
        <div class="col-md-6"><strong>Pertenece a una iglesia</strong><br>{{ $inscripcion->pertenece_iglesia ? 'Sí' : 'No' }}</div>
        @if($inscripcion->pertenece_iglesia)
          <div class="col-md-6"><strong>Iglesia</strong><br>{{ $inscripcion->iglesia }}</div>
          <div class="col-md-6"><strong>Departamento</strong><br>{{ $inscripcion->departamentoCatalogo?->nombre ?? 'No indicado' }}</div>
        @endif
        <div class="col-md-6"><strong>Primera vez en un campamento</strong><br>{{ $inscripcion->primera_vez ? 'Sí' : 'No' }}</div>
      </div>
      <hr><h5 class="card-title">Contacto de emergencia</h5>
      <div class="row g-3"><div class="col-md-6"><strong>Nombre</strong><br>{{ $inscripcion->encargado_nombre }}</div><div class="col-md-6"><strong>Teléfono</strong><br>{{ $inscripcion->encargado_telefono }}</div></div>
      <hr><h5 class="card-title">Salud</h5>
      <p><strong>Alergias:</strong> {{ $inscripcion->tiene_alergias ? 'Sí' : 'No' }}</p>
      @if($inscripcion->tiene_alergias)<div class="alert alert-warning mb-0">{{ $inscripcion->alergias }}</div>@endif
    </div></div>
  </section>
</main>
@endsection
