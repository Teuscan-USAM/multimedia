<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campamento_inscripciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->date('fecha_nacimiento');
            $table->unsignedTinyInteger('edad');
            $table->string('sexo')->nullable();
            $table->string('telefono');
            $table->string('municipio_residencia');
            $table->boolean('pertenece_iglesia');
            $table->string('iglesia')->nullable();
            $table->string('grupo')->nullable();
            $table->boolean('primera_vez');
            $table->string('encargado_nombre');
            $table->string('encargado_telefono');
            $table->boolean('tiene_alergias');
            $table->text('alergias')->nullable();
            $table->timestamps();

            $table->index('nombre_completo');
            $table->index('municipio_residencia');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campamento_inscripciones');
    }
};
