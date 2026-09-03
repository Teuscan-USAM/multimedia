<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('categorias')
            ->whereIn('tipo', ['ingreso', 'egreso'])
            ->update(['iglesia_id' => null]);
    }

    public function down(): void
    {
        // No es posible reconstruir de forma segura la iglesia original.
    }
};