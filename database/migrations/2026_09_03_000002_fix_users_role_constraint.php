<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_rol_check');
        DB::statement("ALTER TABLE users ALTER COLUMN rol TYPE VARCHAR(255) USING rol::text");
        DB::statement("UPDATE users SET rol = 'miembro' WHERE rol = 'cajero'");
        DB::statement("UPDATE users SET rol = 'pastor' WHERE rol = 'bodeguero'");
        DB::statement("ALTER TABLE users ALTER COLUMN rol SET DEFAULT 'miembro'");
        DB::statement("ALTER TABLE users ALTER COLUMN rol SET NOT NULL");
        DB::statement("ALTER TABLE users ADD CONSTRAINT users_rol_check CHECK (rol IN ('admin', 'pastor', 'miembro'))");
    }

    public function down(): void
    {
        // No revertir roles existentes para evitar pérdida de compatibilidad.
    }
};