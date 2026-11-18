<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('campamento_inscripciones', 'distrito_id')) {
            Schema::table('campamento_inscripciones', function (Blueprint $table) {
                $table->integer('distrito_id')->nullable()->after('telefono');
                $table->foreign('distrito_id')
                    ->references('id_distrito')
                    ->on('ctl_distrito')
                    ->nullOnDelete();
            });
        }

        if (Schema::hasColumn('campamento_inscripciones', 'municipio_residencia')) {
            DB::table('campamento_inscripciones')
                ->whereNull('distrito_id')
                ->whereNotNull('municipio_residencia')
                ->get(['id', 'municipio_residencia'])
                ->each(function (object $inscripcion): void {
                    $distritoId = DB::table('ctl_distrito')
                        ->where('nombre', $inscripcion->municipio_residencia)
                        ->value('id_distrito');

                    if ($distritoId !== null) {
                        DB::table('campamento_inscripciones')
                            ->where('id', $inscripcion->id)
                            ->update(['distrito_id' => $distritoId]);
                    }
                });

            Schema::table('campamento_inscripciones', function (Blueprint $table) {
                $table->dropColumn('municipio_residencia');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('campamento_inscripciones', 'municipio_residencia')) {
            Schema::table('campamento_inscripciones', function (Blueprint $table) {
                $table->string('municipio_residencia')->nullable()->after('telefono');
            });
        }

        if (Schema::hasColumn('campamento_inscripciones', 'distrito_id')) {
            Schema::table('campamento_inscripciones', function (Blueprint $table) {
                $table->dropForeign(['distrito_id']);
                $table->dropColumn('distrito_id');
            });
        }
    }
};
