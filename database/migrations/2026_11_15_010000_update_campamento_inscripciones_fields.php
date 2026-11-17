<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('campamento_inscripciones', 'pertenece_iglesia')) {
            Schema::table('campamento_inscripciones', function (Blueprint $table) {
                $table->boolean('pertenece_iglesia')->default(true)->after('municipio_residencia');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('campamento_inscripciones', 'pertenece_iglesia')) {
            Schema::table('campamento_inscripciones', function (Blueprint $table) {
                $table->dropColumn('pertenece_iglesia');
            });
        }
    }
};
