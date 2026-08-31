<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // La tabla `categorias` venía del módulo anterior y requiere `user_id`.
        // Para el nuevo sistema, `categorias` se define por iglesia y tipo, así que `user_id` pasa a ser opcional.
        DB::statement("ALTER TABLE categorias DROP CONSTRAINT IF EXISTS categorias_user_id_foreign");
        DB::statement("ALTER TABLE categorias ALTER COLUMN user_id DROP NOT NULL");
        DB::statement("ALTER TABLE categorias ADD CONSTRAINT categorias_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL");
    }

    public function down(): void
    {
        // Down no implementado
    }
};

