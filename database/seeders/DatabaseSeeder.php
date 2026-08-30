<?php

namespace Database\Seeders;

use App\Models\CategoriaFinanza;
use App\Models\Departamento;
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
                'password' => Hash::make('admin'),
                'activo' => true,
                'rol' => 'admin',
            ]
        );

        // Pastor
        $pastor = User::firstOrCreate(
            ['email' => 'pastor@demo.com'],
            [
                'name' => 'Pastor Demo',
                'password' => Hash::make('demo1234'),
                'activo' => true,
                'rol' => 'pastor',
            ]
        );

        // Miembro
        $miembro = User::firstOrCreate(
            ['email' => 'miembro@miembro.com'],
            [
                'name' => 'Miembro Demo',
                'password' => Hash::make('demo1234'),
                'activo' => true,
                'rol' => 'miembro',
            ]
        ); 
        

        // Iglesia demo
        $iglesia = Iglesia::firstOrCreate(
            ['nombre' => 'Iglesia Demo'],
            [
                'direccion' => 'Calle Principal 123',
                'telefono' => '0000-0000',
                'ciudad' => 'Ciudad',
                'responsable' => 'Pastor Demo',
            ]
        );

        // Asignar iglesia al pastor
        $pastor->iglesiasPastor()->syncWithoutDetaching([$iglesia->id]);

        // Departamento demo
        $depto = Departamento::firstOrCreate(
            ['nombre' => 'Jóvenes', 'iglesia_id' => $iglesia->id],
            [
                'pastor_id' => $pastor->id,
                'miembro_id' => $miembro->id,
                'descripcion' => 'Departamento de jóvenes',
            ]
        );

        // Categorías demo (por iglesia)
        CategoriaFinanza::firstOrCreate(
            ['iglesia_id' => $iglesia->id, 'tipo' => 'ingreso', 'nombre' => 'Ofrenda'],
            []
        );
        CategoriaFinanza::firstOrCreate(
            ['iglesia_id' => $iglesia->id, 'tipo' => 'ingreso', 'nombre' => 'Diezmo'],
            []
        );
        CategoriaFinanza::firstOrCreate(
            ['iglesia_id' => $iglesia->id, 'tipo' => 'egreso', 'nombre' => 'Materiales'],
            []
        );
        CategoriaFinanza::firstOrCreate(
            ['iglesia_id' => $iglesia->id, 'tipo' => 'egreso', 'nombre' => 'Transporte'],
            []
        );
    }
}
