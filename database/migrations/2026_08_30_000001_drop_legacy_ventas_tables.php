<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('detalle_venta');
        Schema::dropIfExists('compras');
        Schema::dropIfExists('imagenes');
        Schema::dropIfExists('ventas');
        Schema::dropIfExists('productos');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->foreignId('proveedor_id')->constrained('proveedores');
            $table->string('codigo');
            $table->string('nombre', 50);
            $table->string('descripcion', 500)->nullable();
            $table->integer('cantidad')->default(0);
            $table->float('precio_compra')->default(0);
            $table->float('precio_venta')->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->float('total_venta');
            $table->timestamps();
        });

        Schema::create('imagenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->string('nombre');
            $table->string('ruta');
            $table->timestamps();
        });

        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('producto_id')->constrained('productos');
            $table->integer('cantidad');
            $table->float('precio_compra');
            $table->timestamps();
        });

        Schema::create('detalle_venta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->constrained('ventas')->cascadeOnDelete();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->integer('cantidad');
            $table->float('precio_unitario');
            $table->float('sub_total');
            $table->timestamps();
        });
    }
};
