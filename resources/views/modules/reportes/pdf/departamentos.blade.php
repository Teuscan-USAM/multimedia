@extends('modules.reportes.pdf.layout')

@section('contenido')
  <h1>Reporte de departamentos</h1>
  <div class="meta">
    Generado por: {{ $usuario->name }}<br>
    Fecha: {{ $generadoEn->format('d/m/Y H:i') }}<br>
    Total en catálogo: {{ $items->count() }}
  </div>

  <table>
    <thead>
      <tr>
        <th>Departamento</th>
        <th>Descripción</th>
        <th>Iglesias habilitadas</th>
        <th>Miembros asignados</th>
      </tr>
    </thead>
    <tbody>
      @forelse($items as $it)
        <tr>
          <td>{{ $it->nombre }}</td>
          <td>{{ $it->descripcion }}</td>
          <td>
            @forelse($it->departamentos as $dep)
              {{ $dep->iglesia?->nombre }}@if(! $loop->last), @endif
            @empty
              Ninguna
            @endforelse
          </td>
          <td>
            @forelse($it->departamentos->filter(fn ($d) => $d->miembro) as $dep)
              {{ $dep->miembro->name }} ({{ $dep->iglesia?->nombre }})@if(! $loop->last), @endif
            @empty
              Sin asignar
            @endforelse
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4">No hay departamentos en el catálogo.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
@endsection
