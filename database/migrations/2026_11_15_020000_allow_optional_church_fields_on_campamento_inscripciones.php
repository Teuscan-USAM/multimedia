<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('campamento_inscripciones', function (Blueprint $table) {
            $table->string('iglesia')->nullable()->change();
            $table->string('grupo')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('campamento_inscripciones', function (Blueprint $table) {
            $table->string('iglesia')->nullable(false)->change();
            $table->string('grupo')->nullable(false)->change();
        });
    }
};
