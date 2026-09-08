@extends('modules.reportes.pdf.layout')

@section('contenido')

  <h1>Reporte de categorías</h1>
  <div class="meta">
    Generado por: {{ $usuario->name }}<br>
    Fecha: {{ $generadoEn->format('d/m/Y H:i') }}<br>
    Total: {{ $items->count() }}
  </div>

  <table>
    <thead>
      <tr>
        <th>Tipo</th>
        <th>Nombre</th>
      </tr>
    </thead>
    <tbody>
      @forelse($items as $it)
        <tr>
          <td>{{ ucfirst($it->tipo) }}</td>
          <td>{{ $it->nombre }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="2">No hay categorías registradas.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
@endsection
