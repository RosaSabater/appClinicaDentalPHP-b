<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\CheckUser;
use App\Http\Middleware\CheckAdmin;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['cors']], function () {

// Usuarios
    Route::get('/', [UsuarioController::class, 'nada']);

    Route::post('/registro', [UsuarioController::class, 'registro']);
    Route::post('/areaclientes/login', [UsuarioController::class, 'login']);
    Route::get('/areaclientes/logout', [UsuarioController::class, 'logout'])->middleware(CheckUser::class);
    Route::delete('/areaclientes/baja', [UsuarioController::class, 'baja'])->middleware(CheckUser::class);


    // Citas
    Route::post('/areaclientes/nuevacita', [CitaController::class, 'nuevaCita'])->middleware(CheckUser::class);
    Route::get('/areaclientes/citas/{usuarioId}', [CitaController::class, 'mostrarCitas'])->middleware(CheckUser::class);
    Route::put('/areaclientes/cancelarcita/{citaId}', [CitaController::class, 'cancelarCita'])->middleware(CheckUser::class);


    //Admin
    Route::get('/admin/mostrarUsuarios', [AdminController::class, 'mostrarUsuarios'])->middleware(CheckAdmin::class);
    Route::get('/admin/mostrarCitas', [AdminController::class, 'mostrarCitas'])->middleware(CheckAdmin::class);
});