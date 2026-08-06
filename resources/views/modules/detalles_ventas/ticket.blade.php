<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura Consumidor Final</title>
    <style>
        body {
            font-family: "Courier New", monospace;
            font-size: 12px;
            margin: 0;
            padding: 10px;
            width: 270px;
            color: #000;
        }

        .ticket {
            width: 100%;
        }

        .titulo {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .subtitulo {
            text-align: center;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .info {
            margin-bottom: 5px;
            line-height: 1.2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        th {
            border-bottom: 1px dashed #000;
            text-align: left;
            font-size: 12px;
        }

        td {
            font-size: 12px;
            padding: 2px 0;
        }

        .right {
            text-align: right;
        }

        .totales {
            margin-top: 8px;
            border-top: 1px dashed #000;
            padding-top: 5px;
            font-size: 12px;
        }

        .totales p {
            margin: 0;
            text-align: right;
        }

        .gracias {
            text-align: center;
            margin-top: 10px;
            font-size: 12px;
            border-top: 1px dashed #000;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="titulo">Tienda Software</div>
        <div class="subtitulo">Factura Consumidor Final</div>

        <div class="info">
            <p><strong>NIT:</strong> 0614-907651-832-1</p>
            <p><strong>Fecha:</strong> {{ $venta->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Cajero:</strong> {{ $venta->nombre_usuario }}</p>
            <p><strong>No. Factura:</strong> {{ $venta->id }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cant.</th>
                    <th class="right">P.Unit</th>
                    <th class="right">Subt.</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $subtotal = 0;
                @endphp
                @foreach ($detalles as $item)
                    @php
                        $subtotal += $item->sub_total;
                    @endphp
                    <tr>
                        <td>{{ $item->nombre_producto }}</td>
                        <td>{{ $item->cantidad }}</td>
                        <td class="right">${{ number_format($item->precio_unitario, 2) }}</td>
                        <td class="right">${{ number_format($item->sub_total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @php
            $iva = $subtotal * 0.13;
            $totalConIVA = $subtotal + $iva;
        @endphp

        <div class="totales">
            <p>Subtotal: ${{ number_format($subtotal, 2) }}</p>
            <p>IVA (13%): ${{ number_format($iva, 2) }}</p>
            <p><strong>Total a Pagar: ${{ number_format($totalConIVA, 2) }}</strong></p>
        </div>

        <div class="gracias">
            ¡Gracias por su compra!<br>
            Vuelva pronto
        </div>
    </div>
</body>
</html>
