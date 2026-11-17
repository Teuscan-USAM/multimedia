@extends('layouts.main')

@section('titulo', 'Inscripciones al campamento')

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle d-flex justify-content-between align-items-center">
    <div><h1>Inscripciones al campamento</h1><p>Respuestas recibidas desde el formulario público.</p></div>
    <div class="d-flex gap-2">
      <a class="btn btn-primary" href="{{ route('campamento.formulario') }}" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Ver formulario público</a>
    </div>
  </div>
  <section class="section">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="row g-3 mb-4">
      @php
        $summaryCards = [
          ['label' => 'Total inscritos', 'value' => $total, 'class' => 'bg-primary text-white', 'icon' => 'bi-people-fill'],
          ['label' => 'Mujeres', 'value' => $mujeres, 'class' => 'bg-danger text-white', 'icon' => 'bi-gender-female'],
          ['label' => 'Hombres', 'value' => $hombres, 'class' => 'bg-info text-white', 'icon' => 'bi-gender-male'],
          ['label' => 'Menores de edad', 'value' => $menores, 'class' => 'bg-warning text-white', 'icon' => 'bi-person-hearts'],
          ['label' => 'Asisten a una iglesia', 'value' => $conIglesia, 'class' => 'bg-success text-white', 'icon' => 'bi-building'],
          ['label' => 'No asisten a una iglesia', 'value' => $sinIglesia, 'class' => 'bg-secondary text-white', 'icon' => 'bi-building-slash'],
          ['label' => 'Con alergias', 'value' => $conAlergias, 'class' => 'bg-dark text-white', 'icon' => 'bi-exclamation-triangle'],
          ['label' => 'Sin alergias', 'value' => $sinAlergias, 'class' => 'bg-light text-dark', 'icon' => 'bi-shield-check'],
        ];
      @endphp
      @foreach($summaryCards as $card)
        <div class="col-6 col-md-3">
          <div class="card h-100 mb-0 border-0 shadow-sm {{ $card['class'] }} {{ $card['label'] === 'Con alergias' ? 'position-relative' : '' }}">
            <div class="card-body text-center py-3">
              <i class="bi {{ $card['icon'] }} fs-4"></i>
              <h6 class="mt-2 mb-1">{{ $card['label'] }}</h6>
              <h2 class="mb-0">{{ $card['value'] }}</h2>
              @if($card['label'] === 'Con alergias')
                <a class="stretched-link" href="{{ route('campamento.alergias.pdf') }}" target="_blank" aria-label="Ver lista de alergias"></a>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="row g-3 mb-4">
      <div class="col-lg-5">
        <div class="card h-100 mb-0">
          <div class="card-body">
            <h5 class="card-title">Participantes por sexo</h5>
            <canvas id="sexoChart" height="220"></canvas>
          </div>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="card h-100 mb-0">
          <div class="card-body">
            <h5 class="card-title">Inscripciones por día</h5>
            @if($inscritosPorDia->isEmpty())
              <p class="text-muted mb-0">Todavía no hay inscripciones registradas.</p>
            @else
              <canvas id="diaChart" height="150"></canvas>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="card"><div class="card-body pt-3"><div class="table-responsive">
      <table class="table datatable align-middle">
        <thead><tr><th>Participante</th><th>Edad</th><th>Teléfono</th><th>Distrito</th><th>Iglesia</th><th>Departamento iglesia</th><th>Emergencia</th><th>Registro</th><th></th></tr></thead>
        <tbody>
          @foreach($inscripciones as $inscripcion)
            <tr>
              <td><strong>{{ $inscripcion->nombre_completo }}</strong></td>
              <td>{{ $inscripcion->edad }} @if($inscripcion->edad < 18)<span class="badge bg-warning text-dark">Menor</span>@endif</td>
              <td>{{ $inscripcion->telefono }}</td>
              <td>{{ $inscripcion->distrito?->nombre ?? '' }}</td>
              <td>{{ $inscripcion->iglesia ?? 'No indicada' }}</td>
              <td>{{ $inscripcion->departamentoCatalogo?->nombre ?? 'No indicado' }}</td>
              <td>{{ $inscripcion->encargado_nombre }}<br><small>{{ $inscripcion->encargado_telefono }}</small></td>
              <td>{{ $inscripcion->created_at?->format('d/m/Y H:i') }}</td>
              <td><a class="btn btn-sm btn-outline-primary" href="{{ route('campamento.show', $inscripcion) }}">Ver ficha</a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div></div></div>
  </section>
</main>
@push('scripts')
<script>
  new Chart(document.getElementById('sexoChart'), {
    type: 'doughnut',
    data: {
      labels: ['Mujeres', 'Hombres', 'No indicado'],
      datasets: [{ data: [{{ $mujeres }}, {{ $hombres }}, {{ $sinSexo }}], backgroundColor: ['#dc3545', '#0dcaf0', '#adb5bd'] }]
    },
    options: { plugins: { legend: { position: 'bottom' } } }
  });

  @if($inscritosPorDia->isNotEmpty())
  new Chart(document.getElementById('diaChart'), {
    type: 'bar',
    data: {
      labels: @json($inscritosPorDia->keys()->map(fn ($fecha) => \Carbon\Carbon::createFromFormat('d/m/Y', $fecha)->locale('es')->translatedFormat('d \d\e F'))->values()),
      datasets: [{ label: 'Inscripciones', data: @json($inscritosPorDia->values()), backgroundColor: '#1f5c48', borderRadius: 6 }]
    },
    options: { scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }, plugins: { legend: { display: false } } }
  });
  @endif
</script>
@endpush
@endsection
