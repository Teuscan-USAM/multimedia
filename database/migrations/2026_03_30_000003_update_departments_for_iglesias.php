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
                $table->foreignId('iglesia_id')->nullable()->constrained('iglesias')->nullOnDelete();
            }
            if (!Schema::hasColumn('departments', 'pastor_id')) {
                $table->foreignId('pastor_id')->nullable()->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('departments', 'miembro_id')) {
                $table->foreignId('miembro_id')->nullable()->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('departments', 'nombre')) {
                $table->string('nombre')->nullable();
            }
            if (!Schema::hasColumn('departments', 'descripcion')) {
                $table->string('descripcion', 500)->nullable();
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

