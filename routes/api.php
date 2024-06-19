<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware([AuthMiddleware::class])->prefix('clients')->group(function () {
    Route::get('/exits', [ClienteController::class, 'exits']);
    Route::post('/', [ClienteController::class, 'create']);
});

Route::middleware([AuthMiddleware::class])->prefix('productos')->group(function () {
    Route::get('/', [ProductoController::class, 'getAll']);
});

Route::middleware([AuthMiddleware::class])->prefix('pedidos')->group(function () {
    Route::post('/', [PedidoController::class, 'create']);
});

Route::middleware([AuthMiddleware::class])->prefix('domotica')->group(function () {
    Route::post('/{switch}', [PedidoController::class, 'switch']);
});

Route::middleware([AuthMiddleware::class])->prefix('map')->group(function () {
    Route::post('address', [PedidoController::class, 'reverseGeocode']);
});
