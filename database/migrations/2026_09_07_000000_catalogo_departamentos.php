<?php

use App\Models\Departamento;
use App\Models\DepartamentoCatalogo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departamento_catalogo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('descripcion', 500)->nullable();
            $table->timestamps();
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->foreignId('catalogo_id')
                ->nullable()
                ->after('iglesia_id')
                ->constrained('departamento_catalogo')
                ->restrictOnDelete();
            $table->boolean('habilitado')->default(true)->after('miembro_id');
        });

        $this->backfillCatalogo();

        Schema::table('departments', function (Blueprint $table) {
            $table->unique(['iglesia_id', 'catalogo_id']);
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn(['nombre', 'descripcion']);
        });
    }

    private function backfillCatalogo(): void
    {
        $rows = DB::table('departments')->orderBy('id')->get();

        foreach ($rows as $row) {
            $nombre = trim((string) ($row->nombre ?? ''));
            if ($nombre === '') {
                $nombre = 'Departamento '.$row->id;
            }

            $catalogo = DepartamentoCatalogo::firstOrCreate(
                ['nombre' => $nombre],
                ['descripcion' => $row->descripcion]
            );

            DB::table('departments')->where('id', $row->id)->update([
                'catalogo_id' => $catalogo->id,
                'habilitado' => true,
            ]);
        }

        $grupos = DB::table('departments')
            ->whereNotNull('iglesia_id')
            ->whereNotNull('catalogo_id')
            ->orderBy('id')
            ->get()
            ->groupBy(fn ($row) => $row->iglesia_id.'-'.$row->catalogo_id);

        foreach ($grupos as $grupo) {
            if ($grupo->count() < 2) {
                continue;
            }

            $keep = $grupo->first();
            $extras = $grupo->slice(1);

            foreach ($extras as $extra) {
                DB::table('ingresos')->where('departamento_id', $extra->id)->update([
                    'departamento_id' => $keep->id,
                ]);
                DB::table('egresos')->where('departamento_id', $extra->id)->update([
                    'departamento_id' => $keep->id,
                ]);

                if ($keep->pastor_id === null && $extra->pastor_id) {
                    DB::table('departments')->where('id', $keep->id)->update([
                        'pastor_id' => $extra->pastor_id,
                    ]);
                }
                if ($keep->miembro_id === null && $extra->miembro_id) {
                    DB::table('departments')->where('id', $keep->id)->update([
                        'miembro_id' => $extra->miembro_id,
                    ]);
                }

                DB::table('departments')->where('id', $extra->id)->delete();
            }
        }
    }

    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->string('nombre')->nullable();
            $table->string('descripcion', 500)->nullable();
        });

        $instances = Departamento::with('catalogo')->get();
        foreach ($instances as $instance) {
            $instance->forceFill([
                'nombre' => $instance->catalogo?->nombre ?? 'Departamento',
                'descripcion' => $instance->catalogo?->descripcion,
            ])->save();
        }

        Schema::table('departments', function (Blueprint $table) {
            $table->dropUnique(['iglesia_id', 'catalogo_id']);
            $table->dropConstrainedForeignId('catalogo_id');
            $table->dropColumn('habilitado');
        });

        Schema::dropIfExists('departamento_catalogo');
    }
};
