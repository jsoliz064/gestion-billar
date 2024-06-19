<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdministrativoController;
use App\Http\Controllers\BotWhatsappController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\ProduccionController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProductoOfertaController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('login'));
});

Auth::routes();

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [userController::class, 'users'])->name('users.index');
        Route::get('user/profile/', [userController::class, 'show2'])->name('user.show');
        Route::patch('user/update/', [userController::class, 'update2'])->name('user.update');
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', [RolController::class, 'index'])->name('roles.index');
        Route::get('create', [RolController::class, 'create'])->name('roles.create');
        Route::get('edit/{id}', [RolController::class, 'edit'])->name('roles.edit');
        Route::get('permisos', [RolController::class, 'permisos'])->name('permisos.index');
    });

    Route::group(['prefix' => 'mesas'], function () {
        Route::get('/', [MesaController::class, 'index'])->name('mesas.index');
    });
});
