<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('campamento_inscripciones', 'grupo')) {
            if (Schema::hasColumn('campamento_inscripciones', 'departamento_catalogo_id')) {
                $catalogo = DB::table('departamento_catalogo')->pluck('id', 'nombre');

                DB::table('campamento_inscripciones')
                    ->whereNull('departamento_catalogo_id')
                    ->whereNotNull('grupo')
                    ->get(['id', 'grupo'])
                    ->each(function (object $inscripcion) use ($catalogo): void {
                        $departamentoId = $catalogo->get($inscripcion->grupo);

                        if ($departamentoId !== null) {
                            DB::table('campamento_inscripciones')
                                ->where('id', $inscripcion->id)
                                ->update(['departamento_catalogo_id' => $departamentoId]);
                        }
                    });
            }

            Schema::table('campamento_inscripciones', function (Blueprint $table) {
                $table->dropColumn('grupo');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('campamento_inscripciones', 'grupo')) {
            Schema::table('campamento_inscripciones', function (Blueprint $table) {
                $table->string('grupo')->nullable()->after('iglesia');
            });
        }
    }
};
