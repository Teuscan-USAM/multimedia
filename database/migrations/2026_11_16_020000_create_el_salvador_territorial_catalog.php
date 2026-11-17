<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();

        if (! in_array($driver, ['mysql', 'pgsql'], true)) {
            throw new \RuntimeException(
                'El catálogo territorial de El Salvador requiere una conexión MySQL o PostgreSQL.'
            );
        }

        $path = database_path('data/el_salvador_division_territorial.sql');

        if (! is_file($path)) {
            throw new RuntimeException("No se encontró el catálogo territorial: {$path}");
        }

        $sql = file_get_contents($path);

        if ($sql === false) {
            throw new RuntimeException("No se pudo leer el catálogo territorial: {$path}");
        }

        if ($driver === 'pgsql') {
            $sql = preg_replace(
                '/\)\s+ENGINE=InnoDB\s+DEFAULT CHARSET=utf8mb4\s+COLLATE=utf8mb4_unicode_ci;/i',
                ');',
                $sql
            );
            $sql = str_replace('INT AUTO_INCREMENT PRIMARY KEY', 'SERIAL PRIMARY KEY', $sql);
            $sql = str_replace('INSERT IGNORE INTO', 'INSERT INTO', $sql);
        }

        DB::unprepared($sql);
    }

    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS ctl_distrito');
        DB::statement('DROP TABLE IF EXISTS ctl_municipio');
        DB::statement('DROP TABLE IF EXISTS ctl_departamento');
        DB::statement('DROP TABLE IF EXISTS ctl_pais');
    }
};
