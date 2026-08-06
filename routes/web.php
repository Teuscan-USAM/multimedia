<?php

use App\Http\Controllers\InicioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\IglesiasController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\DepartamentosController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\IngresosController;
use App\Http\Controllers\EgresosController;
use Illuminate\Support\Facades\Route;

// Crear un usuario admin (solo usar una vez en un entorno nuevo)
Route::get('/crear-admin', [AuthController::class, 'crearAdmin'])->name('seed.admin');

// Página pública de inicio (anuncios)
Route::get('/', [InicioController::class, 'index'])->name('inicio');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/logear', [AuthController::class, 'logear'])->name('logear');


// =========================
// 🔒 Rutas con autenticación
// =========================
Route::middleware('auth')->group(function () {
    Route::get('/home', [Dashboard::class, 'index'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // 👤 Perfil del usuario autenticado
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');
    Route::post('/perfil/update', [PerfilController::class, 'update'])->name('perfil.update');
});

// =====================================================
// 🏛️ Módulos del sistema de iglesias/finanzas
// =====================================================
Route::middleware(['auth', 'Checkrol:admin'])->group(function () {
    // Iglesias (admin)
    Route::prefix('iglesias')->group(function () {
        Route::get('/', [IglesiasController::class, 'index'])->name('iglesias.index');
        Route::get('/create', [IglesiasController::class, 'create'])->name('iglesias.create');
        Route::post('/store', [IglesiasController::class, 'store'])->name('iglesias.store');
        Route::get('/edit/{id}', [IglesiasController::class, 'edit'])->name('iglesias.edit');
        Route::put('/update/{id}', [IglesiasController::class, 'update'])->name('iglesias.update');
        Route::delete('/destroy/{id}', [IglesiasController::class, 'destroy'])->name('iglesias.destroy');
    });

    // Usuarios (admin): crear pastores/miembros + asignaciones + activar/desactivar
    Route::prefix('usuarios')->group(function () {
        Route::get('/', [UsuariosController::class, 'index'])->name('usuarios.index');
        Route::get('/create', [UsuariosController::class, 'create'])->name('usuarios.create');
        Route::post('/store', [UsuariosController::class, 'store'])->name('usuarios.store');
        Route::get('/edit/{id}', [UsuariosController::class, 'edit'])->name('usuarios.edit');
        Route::put('/update/{id}', [UsuariosController::class, 'update'])->name('usuarios.update');
        Route::get('/cambiar-estado/{id}/{estado}', [UsuariosController::class, 'estado'])->name('usuarios.estado');
        Route::post('/asignar-iglesias/{id}', [UsuariosController::class, 'asignarIglesias'])->name('usuarios.asignar.iglesias');
    });
});

Route::middleware(['auth', 'Checkrol:pastor'])->group(function () {
    // Departamentos (pastor)
    Route::prefix('departamentos')->group(function () {
        Route::get('/', [DepartamentosController::class, 'index'])->name('departamentos.index');
        Route::get('/create', [DepartamentosController::class, 'create'])->name('departamentos.create');
        Route::post('/store', [DepartamentosController::class, 'store'])->name('departamentos.store');
        Route::get('/edit/{id}', [DepartamentosController::class, 'edit'])->name('departamentos.edit');
        Route::put('/update/{id}', [DepartamentosController::class, 'update'])->name('departamentos.update');
        Route::delete('/destroy/{id}', [DepartamentosController::class, 'destroy'])->name('departamentos.destroy');
        Route::post('/asignar-miembro/{id}', [DepartamentosController::class, 'asignarMiembro'])->name('departamentos.asignar.miembro');
    });
});

Route::middleware(['auth', 'Checkrol:admin,pastor'])->group(function () {
    // Categorías (admin/pastor) — por iglesia, con tipo ingreso/egreso
    Route::prefix('categorias')->group(function () {
        Route::get('/', [CategoriasController::class, 'index'])->name('categorias.index');
        Route::get('/create', [CategoriasController::class, 'create'])->name('categorias.create');
        Route::post('/store', [CategoriasController::class, 'store'])->name('categorias.store');
        Route::get('/edit/{id}', [CategoriasController::class, 'edit'])->name('categorias.edit');
        Route::put('/update/{id}', [CategoriasController::class, 'update'])->name('categorias.update');
        Route::delete('/destroy/{id}', [CategoriasController::class, 'destroy'])->name('categorias.destroy');
    });
});

Route::middleware(['auth', 'Checkrol:miembro'])->group(function () {
    // Ingresos (solo miembro de su depto)
    Route::prefix('ingresos')->group(function () {
        Route::get('/', [IngresosController::class, 'index'])->name('ingresos.index');
        Route::get('/create', [IngresosController::class, 'create'])->name('ingresos.create');
        Route::post('/store', [IngresosController::class, 'store'])->name('ingresos.store');
        Route::get('/edit/{id}', [IngresosController::class, 'edit'])->name('ingresos.edit');
        Route::put('/update/{id}', [IngresosController::class, 'update'])->name('ingresos.update');
        Route::delete('/destroy/{id}', [IngresosController::class, 'destroy'])->name('ingresos.destroy');
    });

    // Egresos (solo miembro de su depto)
    Route::prefix('egresos')->group(function () {
        Route::get('/', [EgresosController::class, 'index'])->name('egresos.index');
        Route::get('/create', [EgresosController::class, 'create'])->name('egresos.create');
        Route::post('/store', [EgresosController::class, 'store'])->name('egresos.store');
        Route::get('/edit/{id}', [EgresosController::class, 'edit'])->name('egresos.edit');
        Route::put('/update/{id}', [EgresosController::class, 'update'])->name('egresos.update');
        Route::delete('/destroy/{id}', [EgresosController::class, 'destroy'])->name('egresos.destroy');
    });
});
