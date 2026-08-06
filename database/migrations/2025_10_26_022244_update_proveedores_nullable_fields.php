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
        Schema::table('proveedores', function (Blueprint $table) {
            // ✅ Cambiar las columnas sitio_web y notas a nullable
            $table->string('sitio_web')->nullable()->change();
            $table->text('notas')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proveedores', function (Blueprint $table) {
            // En caso de rollback, volver a hacerlas NOT NULL
            $table->string('sitio_web')->nullable(false)->change();
            $table->text('notas')->nullable(false)->change();
        });
    }
};
