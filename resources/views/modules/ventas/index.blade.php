@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Venta de productos</h1>
  </div>

  <!-- ============================ -->
  <!--  LISTADO DE PRODUCTOS -->
  <!-- ============================ -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Crear una nueva venta</h5>
            <p>Seleccione los productos a vender:</p>

            <table class="table table-condensed" id="productos_carrito">
              <thead class="table-light">
                <tr>
                  <th class="text-center">Código</th>
                  <th class="text-center">Nombre</th>
                  <th class="text-center">Cantidad</th>
                  <th class="text-center">Precio</th>
                  <th class="text-center">Agregar</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($items as $item)
                  <tr>
                    <td class="text-center">{{ $item->codigo }}</td>
                    <td class="text-center">{{ $item->nombre }}</td>
                    <td class="text-center">{{ $item->cantidad }}</td>
                    <td class="text-center">${{ number_format($item->precio_venta, 2) }}</td>
                    <td class="text-center">
                      <a href="{{ route('ventas.agregar.carrito', $item->id) }}" class="btn btn-success btn-sm">Agregar</a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
           </table>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================ -->
  <!--  FACTURA / CARRITO -->
  <!-- ============================ -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Factura - Consumidor Final</h5>

            @if (session('items_carrito'))
              @php
                  $subtotal = 0;
              @endphp

              <table class="table table-sm table-bordered">
                <thead class="table-light">
                  <tr>
                    <th class="text-center">Código</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Precio Unitario</th>
                    <th class="text-center">SubTotal</th>
                    <th class="text-center">Quitar</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach (session('items_carrito') as $item)
                    @php
                      $subTotalProducto = $item['cantidad'] * $item['precio'];
                      $subtotal += $subTotalProducto;
                    @endphp
                    <tr>
                      <td class="text-center">{{ $item['codigo'] }}</td>
                      <td class="text-center">{{ $item['nombre'] }}</td>
                      <td class="text-center">{{ $item['cantidad'] }}</td>
                      <td class="text-center">${{ number_format($item['precio'], 2) }}</td>
                      <td class="text-center">${{ number_format($subTotalProducto, 2) }}</td>
                      <td class="text-center">
                        <a href="{{ route('ventas.quitar.carrito', $item['id']) }}" class="btn btn-danger btn-sm">Quitar</a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
                @php
                    $iva = $subtotal * 0.13;
                    $totalGeneral = $subtotal + $iva;
                @endphp
                <tfoot>
                  <tr>
                    <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                    <td colspan="2" class="text-center"><strong>${{ number_format($subtotal, 2) }}</strong></td>
                  </tr>
                  <tr>
                    <td colspan="4" class="text-end"><strong>IVA (13%):</strong></td>
                    <td colspan="2" class="text-center"><strong>${{ number_format($iva, 2) }}</strong></td>
                  </tr>
                  <tr>
                    <td colspan="4" class="text-end"><strong>Total a pagar:</strong></td>
                    <td colspan="2" class="text-center text-success"><strong>${{ number_format($totalGeneral, 2) }}</strong></td>
                  </tr>
                </tfoot>
              </table>

              <div class="text-center mt-4">
                <form action="{{ route('ventas.vender') }}" method="post" style="display: inline-block;">
                  @csrf
                  <button class="btn btn-primary">Generar Factura</button>
                </form>
                <a href="{{ route('ventas.borrar.carrito') }}" class="btn btn-danger">Borrar Carrito</a>
              </div>

            @else
              <p class="text-center text-muted mt-3">No hay productos en el carrito</p>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection

@push('scripts')
<script>
  $(document).ready(function(){
    $('#productos_carrito').DataTable({
      "pageLength" : 10,
      language: {
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "search": "Buscar:",
        "paginate": {
          "first": "Primero",
          "last": "Último",
          "next": "Siguiente",
          "previous": "Anterior"
        }
      }
    });
  });
</script>
@endpush
