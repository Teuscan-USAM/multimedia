<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            if (!Schema::hasColumn('departments', 'iglesia_id')) {
                $table->foreignId('iglesia_id')->nullable()->after('id')->constrained('iglesias')->nullOnDelete();
            }
            if (!Schema::hasColumn('departments', 'pastor_id')) {
                $table->foreignId('pastor_id')->nullable()->after('iglesia_id')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('departments', 'miembro_id')) {
                $table->foreignId('miembro_id')->nullable()->after('pastor_id')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('departments', 'nombre')) {
                $table->string('nombre')->nullable()->after('miembro_id');
            }
            if (!Schema::hasColumn('departments', 'descripcion')) {
                $table->string('descripcion', 500)->nullable()->after('nombre');
            }
        });
    }

    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            // Down conservador (evita romper en entornos con datos)
        });
    }
};

