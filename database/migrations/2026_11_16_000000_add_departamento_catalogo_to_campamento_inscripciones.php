<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('campamento_inscripciones', function (Blueprint $table) {
            $table->foreignId('departamento_catalogo_id')
                ->nullable()
                ->after('grupo')
                ->constrained('departamento_catalogo')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('campamento_inscripciones', function (Blueprint $table) {
            $table->dropConstrainedForeignId('departamento_catalogo_id');
        });
    }
};
