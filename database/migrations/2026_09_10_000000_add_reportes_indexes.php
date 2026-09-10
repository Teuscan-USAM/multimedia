<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ingresos', function (Blueprint $table) {
            $table->index(['departamento_id', 'fecha'], 'ingresos_departamento_fecha_index');
        });

        Schema::table('egresos', function (Blueprint $table) {
            $table->index(['departamento_id', 'fecha'], 'egresos_departamento_fecha_index');
        });
    }

    public function down(): void
    {
        Schema::table('ingresos', function (Blueprint $table) {
            $table->dropIndex('ingresos_departamento_fecha_index');
        });

        Schema::table('egresos', function (Blueprint $table) {
            $table->dropIndex('egresos_departamento_fecha_index');
        });
    }
};