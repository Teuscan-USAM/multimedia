<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('anuncios', 'seccion')) {
            Schema::table('anuncios', function (Blueprint $table) {
                $table->string('seccion')->default('jovenes')->after('imagen');
                $table->index('seccion');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('anuncios', 'seccion')) {
            Schema::table('anuncios', function (Blueprint $table) {
                $table->dropIndex(['seccion']);
                $table->dropColumn('seccion');
            });
        }
    }
};