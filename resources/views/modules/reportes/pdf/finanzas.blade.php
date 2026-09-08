@extends('modules.reportes.pdf.layout')

@section('contenido')
  <h1>Reporte de movimientos</h1>
  <div class="meta">
    Mes: {{ $mes->translatedFormat('F Y') }}<br>
    Generado por: {{ $usuario->name }} ({{ $usuario->rol }})<br>
    Fecha: {{ $generadoEn->format('d/m/Y H:i') }}
  </div>

  <table>
    <tr class="totals">
      <td>Total ingresos</td>
      <td class="right">${{ number_format($totalIngresos, 2) }}</td>
    </tr>
    <tr class="totals">
      <td>Total egresos</td>
      <td class="right">${{ number_format($totalEgresos, 2) }}</td>
    </tr>
    <tr class="totals">
      <td>Saldo</td>
      <td class="right">${{ number_format($saldo, 2) }}</td>
    </tr>
  </table>

  @foreach($porDepartamento as $bloque)
    <h2>{{ $bloque['departamento']->nombre }} — {{ $bloque['departamento']->iglesia?->nombre }}</h2>
    @if($usuario->rol === 'pastor' && $bloque['departamento']->miembro)
      <div class="meta">Miembro: {{ $bloque['departamento']->miembro->name }}</div>
    @endif

    <table>
      <thead>
        <tr>
          <th>Fecha</th>
          <th>Tipo</th>
          <th>Concepto</th>
          <th>Categoría</th>
          <th class="right">Monto</th>
        </tr>
      </thead>
      <tbody>
        @forelse($bloque['ingresos']->concat($bloque['egresos'])->sortByDesc(fn ($m) => $m->fecha->format('Y-m-d').$m->id) as $mov)
          <tr>
            <td>{{ $mov->fecha?->format('d/m/Y') }}</td>
            <td>{{ $mov instanceof \App\Models\Ingreso ? 'Ingreso' : 'Egreso' }}</td>
            <td>{{ $mov->nombre }}</td>
            <td>{{ $mov->categoria?->nombre }}</td>
            <td class="right">${{ number_format($mov->monto, 2) }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="5">Sin movimientos en este mes.</td>
          </tr>
        @endforelse
        <tr class="totals">
          <td colspan="4">Saldo del departamento</td>
          <td class="right">${{ number_format($bloque['saldo'], 2) }}</td>
        </tr>
      </tbody>
    </table>
  @endforeach
@endsection
