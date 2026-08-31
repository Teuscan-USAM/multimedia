<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            // Sintaxis compatible con PostgreSQL
            DB::statement("ALTER TABLE users ALTER COLUMN rol TYPE VARCHAR(255)");
            DB::statement("ALTER TABLE users ALTER COLUMN rol SET DEFAULT 'miembro'");
            DB::statement("ALTER TABLE users ALTER COLUMN rol SET NOT NULL");
        } else {
            // Sintaxis para MySQL / MariaDB
            DB::statement("ALTER TABLE users MODIFY rol ENUM('admin','pastor','miembro') NOT NULL DEFAULT 'miembro'");
        }

        // Re-mapeo básico para usuarios existentes
        DB::statement("UPDATE users SET rol='miembro' WHERE rol='cajero'");
        DB::statement("UPDATE users SET rol='pastor' WHERE rol='bodeguero'");
    }

    public function down(): void
    {
        // Down no implementado para evitar pérdida de compatibilidad
    }
};