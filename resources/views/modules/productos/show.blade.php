@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Eliminar Producto</h1>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Eliminar producto del stock</h5>
            <p class="text-danger fw-bold">
              ⚠️ Una vez que el producto sea eliminado, ¡no podrá ser recuperado!
            </p>
            
            <!-- Tabla de información del producto -->
            <table class="table table-bordered">
              <thead class="table-danger">
                <tr class="text-center">
                  <th>Categoria</th>
                  <th>Proveedor</th>
                  <th>Nombre</th>
                  <th>Imagen</th>
                  <th>Descripción</th>
                  <th>Cantidad</th>
                  <th>Precio compra</th>
                  <th>Precio venta</th>
                  <th>Activo</th>
                </tr>
              </thead>
              <tbody>
                <tr class="text-center">
                  <td>{{ $items->nombre_categoria }}</td>
                  <td>{{ $items->nombre_proveedor }}</td>
                  <td>{{ $items->nombre }}</td>
                  <td>
                    @if(isset($items->imagen_producto))
                      <img src="{{ asset('storage/' . $items->imagen_producto) }}" 
                           alt="Imagen del producto" width="80" class="rounded">
                    @else
                      <span class="text-muted">Sin imagen</span>
                    @endif
                  </td>
                  <td>{{ $items->descripcion }}</td>
                  <td>{{ $items->cantidad }}</td>
                  <td>${{ number_format($items->precio_compra, 2) }}</td>
                  <td>${{ number_format($items->precio_venta, 2) }}</td>
                  <td>
                    <div class="form-check form-switch d-flex justify-content-center">
                      <input class="form-check-input" type="checkbox" 
                             {{ $items->activo ? 'checked' : '' }} disabled>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <!-- Fin de tabla -->

            <hr>

            <!-- 🔴 Formulario de eliminación -->
            <form action="{{ route('productos.destroy', $items->id) }}" method="POST"
                  onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.');">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">
                  <i class="bi bi-trash"></i> Eliminar producto
                </button>
                <a href="{{ route('productos') }}" class="btn btn-info">
                  <i class="bi bi-x-circle"></i> Cancelar
                </a>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
