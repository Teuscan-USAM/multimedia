<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categorias', function (Blueprint $table) {
            if (!Schema::hasColumn('categorias', 'iglesia_id')) {
                $table->foreignId('iglesia_id')->nullable()->after('id')->constrained('iglesias')->nullOnDelete();
            }
            if (!Schema::hasColumn('categorias', 'tipo')) {
                $table->enum('tipo', ['ingreso', 'egreso'])->default('ingreso')->after('nombre');
            }
        });
    }

    public function down(): void
    {
        Schema::table('categorias', function (Blueprint $table) {
            // Down conservador
        });
    }
};

