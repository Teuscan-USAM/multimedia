<?php

namespace Database\Seeders;

use App\Models\CategoriaFinanza;
use App\Models\Departamento;
use App\Models\DepartamentoCatalogo;
use App\Models\Iglesia;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('123'),
                'activo' => true,
                'rol' => 'admin',
            ]
        );

        // Pastor
        $pastor = User::firstOrCreate(
            ['email' => 'miguel@pastor.com'],
            [
                'name' => 'Pastor miguel',
                'password' => Hash::make('123'),
                'activo' => true,
                'rol' => 'pastor',
            ]
        );

        // Miembro
        $miembro = User::firstOrCreate(
            ['email' => 'lincy@miembro.com'],
            [
                'name' => 'Lincy tatiana',
                'password' => Hash::make('123'),
                'activo' => true,
                'rol' => 'miembro',
            ]
        ); 
        

        // Iglesia demo
        $iglesia = Iglesia::firstOrCreate(
            ['nombre' => 'Iglesia Luz y Verdad'],
            [
                'direccion' => 'Calle Principal 123',
                'telefono' => '0000-0000',
                'ciudad' => 'Ciudad',
                'responsable' => '',
            ]
        );

        // Asignar iglesia al pastor
        $pastor->iglesiasPastor()->syncWithoutDetaching([$iglesia->id]);

        $catalogoJovenes = DepartamentoCatalogo::firstOrCreate(
            ['nombre' => 'Jóvenes'],
            ['descripcion' => 'Departamento de jóvenes']
        );

        $depto = Departamento::firstOrCreate(
            [
                'iglesia_id' => $iglesia->id,
                'catalogo_id' => $catalogoJovenes->id,
            ],
            [
                'pastor_id' => $pastor->id,
                'miembro_id' => $miembro->id,
                'habilitado' => true,
            ]
        );

        // Categorías financieras globales para todas las iglesias
        CategoriaFinanza::firstOrCreate(
            ['tipo' => 'ingreso', 'nombre' => 'Ofrenda'],
            []
        );
        CategoriaFinanza::firstOrCreate(
            ['tipo' => 'ingreso', 'nombre' => 'Diezmo'],
            []
        );
        CategoriaFinanza::firstOrCreate(
            ['tipo' => 'egreso', 'nombre' => 'Materiales'],
            []
        );
        CategoriaFinanza::firstOrCreate(
            ['tipo' => 'egreso', 'nombre' => 'Transporte'],
            []
        );
    }
}
