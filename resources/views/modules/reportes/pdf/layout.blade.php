<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>{{ $titulo ?? 'Reporte' }}</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
    h1 { font-size: 18px; margin: 0 0 4px; }
    h2 { font-size: 14px; margin: 16px 0 8px; }
    .meta { color: #555; margin-bottom: 16px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
    th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
    th { background: #f2f2f2; }
    .right { text-align: right; }
    .totals td { font-weight: bold; }
  </style>
</head>
<body>
  <div style="width: 100%; margin-bottom: 20px; clear: both;">
    <div style="float: left; width: 50%;">
      <img src="file://{{ public_path('img/login.png') }}" style="max-height: 80px; height: auto;">
    </div>
    <div style="float: right; width: 50%; text-align: right;">
      <img src="file://{{ public_path('img/ADnegro.png') }}" style="max-height: 80px; height: auto;">
    </div>
    <div style="clear: both;"></div>
  </div>
  @yield('contenido')
</body>
</html>
