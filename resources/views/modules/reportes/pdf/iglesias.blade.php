@extends('modules.reportes.pdf.layout')

@section('contenido')
  <h1>Reporte de iglesias</h1>
  <div class="meta">
    Generado por: {{ $usuario->name }}<br>
    Fecha: {{ $generadoEn->format('d/m/Y H:i') }}<br>
    Total: {{ $items->count() }}
  </div>

  <table>
    <thead>
      <tr>
        <th>Iglesia</th>
        <th>Ciudad</th>
        <th>Pastor</th>
        <th>Teléfono</th>
        <th>Departamentos habilitados</th>
      </tr>
    </thead>
    <tbody>
      @forelse($items as $it)
        <tr>
          <td>{{ $it->nombre }}</td>
          <td>{{ $it->ciudad }}</td>
          <td>{{ $it->pastorResponsable?->name ?? $it->responsable }}</td>
          <td>{{ $it->telefono }}</td>
          <td>
            {{ $it->departamentos_habilitados_count }}
            @if($it->departamentosHabilitados->isNotEmpty())
              ({{ $it->departamentosHabilitados->map(fn ($d) => $d->nombre)->filter()->join(', ') }})
            @endif
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5">No hay iglesias registradas.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
@endsection
