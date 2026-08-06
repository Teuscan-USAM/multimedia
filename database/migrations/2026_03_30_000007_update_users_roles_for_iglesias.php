<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Convertimos el enum anterior (admin,cajero,bodeguero) al set nuevo (admin,pastor,miembro).
        // Nota: esto asume MySQL/MariaDB. En otros motores se debe ajustar.
        DB::statement("ALTER TABLE users MODIFY rol ENUM('admin','pastor','miembro') NOT NULL DEFAULT 'miembro'");

        // Re-mapeo básico para no romper usuarios existentes
        DB::statement("UPDATE users SET rol='miembro' WHERE rol='cajero'");
        DB::statement("UPDATE users SET rol='pastor' WHERE rol='bodeguero'");
    }

    public function down(): void
    {
        // Down no implementado para evitar pérdida de compatibilidad
    }
};

