<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de alergias</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; color: #222; font-size: 12px; }
    h1 { color: #1f5c48; margin-bottom: 4px; }
    .meta { color: #666; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #bbb; padding: 8px; text-align: left; vertical-align: top; }
    th { background: #1f5c48; color: #fff; }
    .empty { text-align: center; color: #666; }
  </style>
</head>
<body>
  <h1>Lista de alergias</h1>
  <div class="meta">
    Generado: {{ $generadoEn->format('d/m/Y H:i') }}<br>
    Personas registradas: {{ $inscripciones->count() }}
  </div>
  <table>
    <thead>
      <tr>
        <th>Persona</th>
        <th>Edad</th>
        <th>Teléfono</th>
        <th>Residencia</th>
        <th>Alergia e indicaciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($inscripciones as $inscripcion)
        <tr>
          <td>{{ $inscripcion->nombre_completo }}</td>
          <td>{{ $inscripcion->edad }} años</td>
          <td>{{ $inscripcion->telefono }}</td>
          <td>{{ $inscripcion->distrito?->municipio?->departamento?->nombre ?? 'No indicado' }} / {{ $inscripcion->distrito?->municipio?->nombre ?? 'No indicado' }} / {{ $inscripcion->distrito?->nombre ?? 'No indicado' }}</td>
          <td>{{ $inscripcion->alergias }}</td>
        </tr>
      @empty
        <tr>
          <td class="empty" colspan="5">No hay personas con alergias registradas.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</body>
</html>
